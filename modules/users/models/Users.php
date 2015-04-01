<?php

namespace app\modules\users\models;

use Yii;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $hash
 * @property string $question
 * @property string $answer
 * @property string $organization
 * @property string $avatar
 * @property string $balance
 * @property integer $created
 * @property integer $role
 * @property integer $ban
 * @property integer $pass1
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'hash'], 'required'],
            [['balance'], 'number'],
            [['email'], 'email'],
            [['created', 'role', 'ban'], 'integer'],
            [['name', 'email', 'answer', 'organization', 'avatar'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 125],
            [['hash', 'question'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'hash' => 'Hash',
            'question' => 'Контрольный вопрос',
            'answer' => 'Контрольный ответ',
            'organization' => 'Организация',
            'avatar' => 'Аватар',
            'balance' => 'Баланс(руб.)',
            'created' => 'Дата регистрации',
            'role' => 'Роль',
            'ban' => 'Забанен',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->ban = 0;
            $this->role = 2;
            $this->balance = 0;
            $this->created = time();
            $this->hash = Yii::$app->getSecurity()->generatePasswordHash($this->pass1);
            return true;
        } else {
            return false;
        }
    }
}
