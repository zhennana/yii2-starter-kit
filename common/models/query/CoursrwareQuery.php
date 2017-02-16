<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\courseware\Courseware]].
 *
 * @see \common\models\courseware\Courseware
 */
class CoursrwareQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\courseware\Courseware[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\courseware\Courseware|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
