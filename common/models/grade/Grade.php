<?php

namespace common\models\grade;

use Yii;

/**
 * This is the model class for table "{{%grade}}".
 *
 * @property integer $grade_id
 * @property integer $school_id
 * @property integer $classroom_group_levels
 * @property string $grade_name
 * @property integer $grade_title
 * @property integer $owner_id
 * @property integer $creater_id
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $sort
 * @property integer $status
 * @property integer $graduate
 * @property integer $time_of_graduation
 * @property integer $time_of_enrollment
 *
 * @property GradeProfile $gradeProfile
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grade}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('campus');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id', 'grade_title', 'creater_id'], 'required'],
            [['school_id', 'classroom_group_levels', 'grade_title', 'owner_id', 'creater_id', 'updated_at', 'created_at', 'sort', 'status', 'graduate', 'time_of_graduation', 'time_of_enrollment'], 'integer'],
            [['grade_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grade_id' => Yii::t('common', '班级ID'),
            'school_id' => Yii::t('common', '学校ID'),
            'classroom_group_levels' => Yii::t('common', '根据学校表学制，显示几年级：年级组1,2,3,4,5,6：2表示整个2年级组'),
            'grade_name' => Yii::t('common', '几年级classroom_group_levels 几班grade_title'),
            'grade_title' => Yii::t('common', '几班'),
            'owner_id' => Yii::t('common', '所属班主任ID'),
            'creater_id' => Yii::t('common', '创建者ID'),
            'updated_at' => Yii::t('common', '创建时间戳'),
            'created_at' => Yii::t('common', '创建时间戳'),
            'sort' => Yii::t('common', '默认与排序'),
            'status' => Yii::t('common', '状态:10 正常；0标记删除'),
            'graduate' => Yii::t('common', '0未毕业；1毕业'),
            'time_of_graduation' => Yii::t('common', '毕业时间：年表示第几届'),
            'time_of_enrollment' => Yii::t('common', '入学时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGradeProfile()
    {
        return $this->hasOne(GradeProfile::className(), ['grade_id' => 'grade_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\GradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GradeQuery(get_called_class());
    }
}
