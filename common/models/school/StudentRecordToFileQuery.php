<?php

namespace common\models\school;

/**
 * This is the ActiveQuery class for [[StudentRecordToFile]].
 *
 * @see StudentRecordToFile
 */
class StudentRecordToFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return StudentRecordToFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StudentRecordToFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
