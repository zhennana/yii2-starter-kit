<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\grade\GradeProfile]].
 *
 * @see \common\models\grade\GradeProfile
 */
class GradeProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\grade\GradeProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\grade\GradeProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
