<?php

namespace common\models\school;

use Yii;

/**
 * This is the model class for table "{{%student_record}}".
 *
 * @property integer $student_record_id
 * @property integer $user_id
 * @property integer $school_id
 * @property integer $grade_id
 * @property string $title
 * @property integer $status
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $created_at
 */
class StudentRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student_record}}';
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
            [['user_id', 'school_id', 'grade_id', 'title', 'updated_at', 'created_at'], 'required'],
            [['user_id', 'school_id', 'grade_id', 'status', 'sort', 'updated_at', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_record_id' => Yii::t('common', '自增ID'),
            'user_id' => Yii::t('common', '用户ID'),
            'school_id' => Yii::t('common', '学校ID'),
            'grade_id' => Yii::t('common', '班级ID'),
            'title' => Yii::t('common', '标题'),
            'status' => Yii::t('common', '1：正常；0标记删除；2待审核；'),
            'sort' => Yii::t('common', '默认与排序'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\StudentRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\StudentRecordQuery(get_called_class());
    }
}
