<?php

namespace app\modules\user\models;

use dektrium\user\models\User as BaseUser;
use dektrium\user\helpers\Password;
use yii\db\BaseActiveRecord;

class User extends BaseUser
{
    public function attributeLabels()
    {
        return [
            'username'          => \Yii::t('user', 'Username'),
            'email'             => \Yii::t('user', 'Email'),
            'phone'             => \Yii::t('user', 'Телефон'),
            'registration_ip'   => \Yii::t('user', 'Registration ip'),
            'unconfirmed_email' => \Yii::t('user', 'New email'),
            'password'          => \Yii::t('user', 'Password'),
            'created_at'        => \Yii::t('user', 'Registration time'),
            'confirmed_at'      => \Yii::t('user', 'Confirmation time'),
        ];
    }

    public function scenarios()
    {
        return [
            'register' => ['username', 'email', 'phone', 'password'],
            'connect'  => ['username', 'email', 'phone'],
            'create'   => ['username', 'email', 'phone', 'password'],
            'update'   => ['username', 'email', 'phone', 'password'],
            'settings' => ['username', 'email', 'phone', 'password']
        ];
    }

    public function rules()
    {
        return [
            // username rules
            ['username', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            ['username', 'string', 'min' => 3, 'max' => 25],
            ['username', 'unique'],
            ['username', 'trim'],

            // email rules
            ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique'],
            ['email', 'trim'],

            // phone rules
            ['phone', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            ['phone', 'string', 'min' => 6, 'max' => 255],
            ['phone', 'trim'],

            // password rules
            ['password', 'required', 'on' => ['register']],
            ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],

            ['balance', 'number'],
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            if (\Yii::$app instanceof \yii\web\Application) {
                $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
            }
            $this->setAttribute('role', 2);
            $this->setAttribute('balance', 0);
        }

        if (!empty($this->password)) {
            $this->setAttribute('password_hash', Password::hash($this->password));
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $profile = \Yii::createObject([
                'class'          => Profile::className(),
                'user_id'        => $this->id,
                //'gravatar_email' => $this->email,
            ]);
            $profile->save(false);
        }
        BaseActiveRecord::afterSave($insert, $changedAttributes);
    }
}
