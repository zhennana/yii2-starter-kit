<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\UsersToUsers as BaseUsersToUsers;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * This is the model class for table "users_to_users".
 */
class UsersToUsers extends BaseUsersToUsers
{

    public function behaviors()
        {
            return ArrayHelper::merge(
                parent::behaviors(),
                [
                    # custom behaviors
                ]
            );
        }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    /**
     * [getOtherUsers 获取其他用户（未关联学校且未关联学生的普通用户）]
     * @return [type] [description]
     */
    public function getOtherUsers()
    {
        $data = [];

        $query = User::find();
        $query->where(['status' => User::STATUS_ACTIVE]);
        $query->andWhere(['NOT',['id' => self::getStudentsId()]]);
        if ($this->isNewRecord || $this->status == self::UTOU_STATUS_DELETE) {
            $query->andWhere(['NOT',['id' => self::relevanceId()]]);
        }
        $user = $query->asArray()->all();

        foreach ($user as $key => $value) {
            if(!empty($value['realname'])){
                $value['name'] = $value['realname'];
                $data[] = $value;
                continue;
            }
            if(!empty($value['username'])){
                $value['name'] = $value['username'];
                $data[] = $value;
                continue;
            }
            if(!empty($value['phone_number'])){
                $value['name'] = $value['phone_number'];
            }

            $data[] = $value;
        }
        return ArrayHelper::map($data,'id','name');
    }
}
