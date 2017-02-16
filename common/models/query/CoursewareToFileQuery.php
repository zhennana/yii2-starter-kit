<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\courseware\CoursewareToFile]].
 *
 * @see \common\models\courseware\CoursewareToFile
 */
class CoursewareToFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\courseware\CoursewareToFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\courseware\CoursewareToFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
