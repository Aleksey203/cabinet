<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property integer $id
 * @property integer $date
 * @property string $user_id
 * @property string $summa
 */
class Transactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'user_id', 'summa'], 'required'],
            [['date', 'user_id'], 'integer'],
            [['summa'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'дата',
            'user_id' => 'id пользователя',
            'summa' => 'сумма',
        ];
    }
}
