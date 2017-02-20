<?php

namespace common\models\courseware;

use Yii;

/**
 * This is the model class for table "{{%courseware_to_file}}".
 *
 * @property integer $courseware_to_file_id
 * @property integer $school_id
 * @property integer $grade_id
 * @property string $title
 * @property integer $status
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $created_at
 */
class CoursewareToFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%courseware_to_file}}';
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
            [['school_id', 'grade_id', 'title', 'updated_at', 'created_at'], 'required'],
            [['school_id', 'grade_id', 'status', 'sort', 'updated_at', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courseware_to_file_id' => Yii::t('common', '课件附件关系自增ID'),
            'school_id' => Yii::t('common', '学校ID'),
            'grade_id' => Yii::t('common', '班级ID'),
            'title' => Yii::t('common', '标题'),
            'status' => Yii::t('common', '1：正常；0标记删除；2待审核； '),
            'sort' => Yii::t('common', '默认与排序'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\CoursewareToFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CoursewareToFileQuery(get_called_class());
    }
}
