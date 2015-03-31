<?php

namespace app\modules\users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\users\models\Users;

/**
 * UsersSearch represents the model behind the search form about `app\modules\users\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created', 'role', 'ban'], 'integer'],
            [['name', 'email', 'phone', 'hash', 'question', 'answer', 'organization', 'avatar'], 'safe'],
            [['balance'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'balance' => $this->balance,
            'created' => $this->created,
            'role' => $this->role,
            'ban' => $this->ban,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'hash', $this->hash])
            ->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'avatar', $this->avatar]);

        return $dataProvider;
    }
}
