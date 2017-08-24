<?php

namespace backend\modules\campus\models\query;

use backend\modules\campus\models\ActivationCode;

/**
 * This is the ActiveQuery class for [[\backend\modules\campus\models\ActivationCode]].
 *
 * @see \backend\modules\campus\models\ActivationCode
 */
class ActivationCodeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\ActivationCode[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\ActivationCode|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function notActive()
    {
        $this->andWhere(['status' => ActivationCode::STATUS_INACTIVATED]);
        return $this;
    }

    /**
     * @return $this
     */
    public function notExpired()
    {
        $this->andWhere(['>','expired_at',time()]);
        return $this;
    }
}
