<?php

namespace common\models\school;

use Yii;

/**
 * This is the model class for table "{{%student_record_title}}".
 *
 * @property integer $student_record_title_id
 * @property string $title
 * @property integer $status
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $created_at
 */
class StudentRecordTitle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student_record_title}}';
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
            [['title', 'updated_at', 'created_at'], 'required'],
            [['status', 'sort', 'updated_at', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_record_title_id' => Yii::t('common', '自增ID'),
            'title' => Yii::t('common', '标题'),
            'status' => Yii::t('common', '1：正常；0标记删除；2待审核；'),
            'sort' => Yii::t('common', '默认与排序'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\StudentRecordTitleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\StudentRecordTitleQuery(get_called_class());
    }
}
