<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\school\StudentRecord]].
 *
 * @see \common\models\school\StudentRecord
 */
class StudentRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\school\StudentRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\school\StudentRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
