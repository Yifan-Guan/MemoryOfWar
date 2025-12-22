<?php

namespace frontend\models; // <--- 重点：这里改成了 frontend

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Hero;

/**
 * HeroSearch represents the model behind the search form of `common\models\Hero`.
 */
class HeroSearch extends Hero
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'life_span', 'identity', 'war_zone', 'quote', 'description', 'photo_path'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Hero::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 4, // 保持我们之前设置的每页4个
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'life_span', $this->life_span])
            ->andFilterWhere(['like', 'identity', $this->identity])
            ->andFilterWhere(['like', 'war_zone', $this->war_zone])
            ->andFilterWhere(['like', 'quote', $this->quote])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'photo_path', $this->photo_path]);

        return $dataProvider;
    }
}