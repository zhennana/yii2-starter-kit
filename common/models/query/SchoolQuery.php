<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\school\School]].
 *
 * @see \common\models\school\School
 */
class SchoolQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\school\School[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\school\School|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
