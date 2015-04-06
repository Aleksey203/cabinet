<?php

namespace app\modules\user\models;

use dektrium\user\models\SettingsForm as BaseSettingsForm;
use dektrium\user\Mailer;
use dektrium\user\Module;
use dektrium\user\helpers\Password;


class SettingsForm extends BaseSettingsForm
{
    /** @var string */
    public $phone;

    /** @var string */
    public $email;

    /** @var string */
    public $username;

    /** @var string */
    public $new_password;

    /** @var string */
    public $current_password;

    /** @var Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;


    /** @inheritdoc */
    public function __construct(Mailer $mailer, $config = [])
    {
        $this->mailer = $mailer;
        $this->setAttributes([
            'phone' => $this->user->phone,
        ], false);
        parent::__construct($mailer, $config);
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            'usernameRequired' => ['username', 'required'],
            'usernameTrim' => ['username', 'filter', 'filter' => 'trim'],
            'usernameLenth' => ['username', 'string', 'min' => 3, 'max' => 20],
            'usernamePattern' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            'emailRequired' => ['email', 'required'],
            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],
            'emailPattern' => ['email', 'email'],
            'phoneRequired' => ['phone', 'required'],
            'phoneLength' => ['phone', 'string'],
            'emailUsernameUnique' => [['email', 'username'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user->$attribute != $model->$attribute;
                }, 'targetClass' => $this->module->modelMap['User']],
            'newPasswordLength' => ['new_password', 'string', 'min' => 6],
            'currentPasswordRequired' => ['current_password', 'required'],
            'currentPasswordValidate' => ['current_password', function ($attr) {
                if (!Password::validate($this->$attr, $this->user->password_hash)) {
                    $this->addError($attr, \Yii::t('user', 'Current password is not valid'));
                }
            }]
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email'            => \Yii::t('user', 'Email'),
            'username'         => \Yii::t('user', 'Username'),
            'phone'         => \Yii::t('user', 'Телефон'),
            'new_password'     => \Yii::t('user', 'New password'),
            'current_password' => \Yii::t('user', 'Current password')
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            $this->user->scenario = 'settings';
            $this->user->username = $this->username;
            $this->user->phone = $this->phone;
            $this->user->password = $this->new_password;
            if ($this->email == $this->user->email && $this->user->unconfirmed_email != null) {
                $this->user->unconfirmed_email = null;
            } else if ($this->email != $this->user->email) {
                switch ($this->module->emailChangeStrategy) {
                    case Module::STRATEGY_INSECURE:
                        $this->insecureEmailChange(); break;
                    case Module::STRATEGY_DEFAULT:
                        $this->defaultEmailChange(); break;
                    case Module::STRATEGY_SECURE:
                        $this->secureEmailChange(); break;
                    default:
                        throw new \OutOfBoundsException('Invalid email changing strategy');
                }
            }
            return $this->user->save();
        }

        return false;
    }
}
