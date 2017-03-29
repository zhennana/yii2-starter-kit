<?php

namespace frontend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\modules\campus\models\Contact]].
 *
 * @see \backend\modules\campus\models\Contact
 */
class ContactQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\Contact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\Contact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
