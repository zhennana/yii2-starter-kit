<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/e0080b9d6ffa35acb85312bf99a557f2
 *
 * @package default
 */


namespace backend\modules\campus\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\campus\models\CoursewareCategory;

/**
 * CoursewareCategorySearch represents the model behind the search form about `backend\modules\campus\models\CoursewareCategory`.
 */
class CoursewareCategorySearch extends CoursewareCategory
{

	/**
	 *
	 * @inheritdoc
	 * @return unknown
	 */
	public function rules() {
		return [
			[['category_id', 'parent_id', 'creater_id', 'updated_at', 'created_at', 'status'], 'integer'],
			[['name', 'description', 'banner_src'], 'safe'],
		];
	}


	/**
	 *
	 * @inheritdoc
	 * @return unknown
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}


	/**
	 * Creates data provider instance with search query applied
	 *
	 *
	 * @param array   $params
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = CoursewareCategory::find();

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
				'category_id' => $this->category_id,
				'parent_id' => $this->parent_id,
				'creater_id' => $this->creater_id,
				'updated_at' => $this->updated_at,
				'created_at' => $this->created_at,
				'status' => $this->status,
			]);

		$query->andFilterWhere(['like', 'name', $this->name])
		->andFilterWhere(['like', 'description', $this->description])
		->andFilterWhere(['like', 'banner_src', $this->banner_src]);

		return $dataProvider;
	}


}
