<?php

namespace app\modules\users\models;

use Yii;

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
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'hash' => 'Hash',
            'question' => 'Контрольный вопрос',
            'answer' => 'Контрольный ответ',
            'organization' => 'Организация',
            'avatar' => 'Аватар',
            'balance' => 'Баланс',
            'created' => 'Created',
            'role' => 'Role',
            'ban' => 'Ban',
        ];
    }
}
