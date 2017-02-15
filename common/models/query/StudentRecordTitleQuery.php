<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\school\StudentRecordTitle]].
 *
 * @see \common\models\school\StudentRecordTitle
 */
class StudentRecordTitleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\school\StudentRecordTitle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\school\StudentRecordTitle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
