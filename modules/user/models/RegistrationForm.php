<?php

namespace app\modules\user\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;


class RegistrationForm extends BaseRegistrationForm
{
    /** @var string */
    public $phone;

    /** @inheritdoc */
    public function rules()
    {
        return [
            'usernameTrim' => ['username', 'filter', 'filter' => 'trim'],
            'usernamePattern' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            'usernameRequired' => ['username', 'required'],
            'usernameUnique' => ['username', 'unique', 'targetClass' => $this->module->modelMap['User'],
                'message' => \Yii::t('user', 'This username has already been taken')],
            'usernameLength' => ['username', 'string', 'min' => 3, 'max' => 20],

            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'emailUnique' => ['email', 'unique', 'targetClass' => $this->module->modelMap['User'],
                'message' => \Yii::t('user', 'This email address has already been taken')],

            'phoneTrim' => ['phone', 'filter', 'filter' => 'trim'],
            //['phone', 'match', 'pattern' => '/^[-+0-9]+$/'],
            'phoneRequired' =>['phone', 'required'],
            'phoneLength' =>['phone', 'string', 'min' => 7, 'max' => 30],

            'passwordRequired' => ['password', 'required', 'skipOnEmpty' => $this->module->enableGeneratingPassword],
            'passwordLength' => ['password', 'string', 'min' => 6],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email'    => \Yii::t('user', 'Email'),
            'username' => \Yii::t('user', 'Username'),
            'phone' => \Yii::t('user', 'Phone'),
            'password' => \Yii::t('user', 'Password'),
        ];
    }

    /**
     * Registers a new user account.
     * @return bool
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'password' => $this->password
        ]);

        return $this->user->register();
    }
}
