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
use backend\modules\campus\models\CoursewareToCourseware;

/**
 * CoursewareToCoursewareSearch represents the model behind the search form about `backend\modules\campus\models\CoursewareToCourseware`.
 */
class CoursewareToCoursewareSearch extends CoursewareToCourseware
{

	/**
	 *
	 * @inheritdoc
	 * @return unknown
	 */
	public function rules() {
		return [
			[['courseware_to_courseware_id', 'courseware_master_id', 'courseware_id', 'status', 'sort', 'updated_at', 'created_at'], 'integer'],
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
		$query = CoursewareToCourseware::find();

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
				'courseware_to_courseware_id' => $this->courseware_to_courseware_id,
				'courseware_master_id' => $this->courseware_master_id,
				'courseware_id' => $this->courseware_id,
				'status' => $this->status,
				'sort' => $this->sort,
				'updated_at' => $this->updated_at,
				'created_at' => $this->created_at,
			]);

		return $dataProvider;
	}


}
