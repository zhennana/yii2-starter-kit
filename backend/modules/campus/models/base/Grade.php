<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "grade".
 *
 * @property integer $grade_id
 * @property integer $school_id
 * @property integer $classroom_group_levels
 * @property string  $grade_name
 * @property integer $grade_title
 * @property integer $owner_id
 * @property integer $creater_id
 * @property integer $sort
 * @property integer $status
 * @property integer $graduate
 * @property integer $time_of_graduation
 * @property integer $time_of_enrollment
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property \backend\modules\campus\models\GradeProfile $gradeProfile
 * @property string $aliasModel
 */
abstract class Grade extends \yii\db\ActiveRecord
{
    CONST GRADE_STATUS_OPEN = 10;//正常。
    CONST GRANE_STATUS_DELECT = 0;//标记性删除。

    CONST GRANE_GRADUATE = 1;//毕业
    CONST GRADE_NOT_GRADUATE = 0;//未毕业

    public static function optsGraduate(){
        return [
            self::GRADE_NOT_GRADUATE => '未毕业',
            self::GRANE_GRADUATE     => '已毕业',
        ];
    }

    public static function getGraduateValue($value){
        $label = self::optsGraduate();
        if(isset($label[$value])){
            return $label[$value];
        }
        return $value;
    }

    public static  function optsStatus(){
        return [
            self::GRADE_STATUS_OPEN => '开启',
            self::GRANE_STATUS_DELECT => '删除'
        ];
    }

    public static function getStatusValueLabel($value){
        $label = self::optsStatus();
        if(isset($label[$value])){
            return $label[$value];
        }
        return $value;
    }
     /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        //return \Yii::$app->modules['campus']->get('campus');
        return Yii::$app->get('campus');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grade';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id','group_category_id'], 'required'],
            ['creater_id','default','value'=>Yii::$app->user->identity->id],
            [['school_id', 'owner_id', 'creater_id', 'sort', 'status', 'graduate', 'time_of_graduation', 'time_of_enrollment','group_category_id'], 'integer'],
            [['grade_name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grade_id'           => Yii::t('common', '班级ID'),
            'school_id'          => Yii::t('common', '学校'),
            'grade_name'         => Yii::t('common', '班级名'),
            'grade_title'        => Yii::t('common', '几班'),
            'group_category_id'  => Yii::t('common', '班级分类'),
            'owner_id'           => Yii::t('common', '班主任'),
            'creater_id'         => Yii::t('common', '创建者'),
            'updated_at'         => Yii::t('common', '创建时间'),
            'created_at'         => Yii::t('common', '创建时间'),
            'sort'               => Yii::t('common', '排序'),
            'status'             => Yii::t('common', '活动状态'),
            'graduate'           => Yii::t('common', '毕业状态'),
            'time_of_graduation' => Yii::t('common', '毕业时间'),
            'time_of_enrollment' => Yii::t('common', '入学时间'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            // 'grade_id'                  => Yii::t('common', '班级ID'),
            // 'school_id'                 => Yii::t('common', '学校ID'),
            // 'group_category_id'         => Yii::t('common','班级分类'),
            // 'classroom_group_levels' => Yii::t('common', '班级名称'),
            'grade_name'                => Yii::t('common', '班级名称'),
            'grade_title'               => Yii::t('common', '请填写数字'),
            // 'owner_id'                  => Yii::t('common', '班主任'),
            'creater_id'                => Yii::t('common', '创建者'),
            'updated_at'                => Yii::t('common', '更新时间'),
            'created_at'                => Yii::t('common', '创建时间'),
            'sort'                      => Yii::t('common', '排序'),
            'status'                    => Yii::t('common', '状态'),
            'graduate'                  => Yii::t('common', '0未毕业；1毕业'),
            'time_of_graduation'        => Yii::t('common', '毕业时间：年表示第几届'),
            'time_of_enrollment'        => Yii::t('common', '入学时间'),
        ]);
    }
    public function fields(){
        return array_merge(parent::fields(),[
                'creater_id'=>function(){
                    return (int)$this->creater_id;
                },
                'school_id'=>function(){
                    return (int)$this->school_id;
                },
                'owner_id'=>function(){
                    return (int)$this->owner_id;
                },
                'sort'=>function(){
                    return (int)$this->sort;
                },
                'status'=>function(){
                    return (int)$this->status;
                },
                'group_category_id'=>function(){
                    return (int)$this->group_category_id;
                },
                'grade_title'=>function(){
                    return (int)$this->grade_title;
                }
            ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGradeProfile()
    {
        return $this->hasOne(\backend\modules\campus\models\GradeProfile::className(), ['grade_id' => 'grade_id']);
    }
    /**
     * *
     * @return [type] [description]
     */
    public function getSchool(){
        return $this->hasOne(\backend\modules\campus\models\School::className(),['id'=>'school_id']);
    }
    
    public function getGradeCategory(){
        return $this->hasOne(\backend\modules\campus\models\GradeCategory::ClassName(),['grade_category_id'=>'group_category_id']);
    }

    public static function getUserName($id)
    {
        $user = \common\models\User::findOne($id);
        $name = '';
        if(isset($user->realname) && !empty($user->realname)){
            return $user->realname;
        }
        if(isset($user->username) && !empty($user->username)){
           return $user->username;
        }
        // if(isset($user->phone_number) && !empty($user->phone_number)){
        //     return $user->phone_number;
        // }
        return $name;
    }

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\query\GradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\campus\models\query\GradeQuery(get_called_class());
    }

}
