<?php

namespace frontend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\modules\campus\models\ApplyToPlay]].
 *
 * @see \backend\modules\campus\models\ApplyToPlay
 */
class ApplyToPlayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\ApplyToPlay[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\ApplyToPlay|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
