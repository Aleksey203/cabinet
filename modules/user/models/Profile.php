<?php

namespace app\modules\user\models;

use dektrium\user\models\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public function rules()
    {
        return [
            [['bio'], 'string'],
            [['public_email'], 'email'],
            ['website', 'url'],
            ['avatar', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 3*1024*1024],
            [['name', 'public_email', 'location', 'website'], 'string', 'max' => 255],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'name'           => \Yii::t('user', 'Name'),
            'public_email'   => \Yii::t('user', 'Email (public)'),
            'avatar'         => \Yii::t('user', 'Фото'),
            'location'       => \Yii::t('user', 'Location'),
            'website'        => \Yii::t('user', 'Website'),
            'bio'            => \Yii::t('user', 'Bio'),
        ];
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            return true;
        }

        return false;
    }
}
