<?php

namespace common\models\school;

use Yii;

/**
 * This is the model class for table "{{%student_record_to_file}}".
 *
 * @property integer $student_record_to_file_id
 * @property integer $student_record_item_id
 * @property integer $file_storage_item_id
 */
class StudentRecordToFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student_record_to_file}}';
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
            [['student_record_item_id', 'file_storage_item_id'], 'required'],
            [['student_record_item_id', 'file_storage_item_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_record_to_file_id' => Yii::t('common', 'Student Record To File ID'),
            'student_record_item_id' => Yii::t('common', 'Student Record Item ID'),
            'file_storage_item_id' => Yii::t('common', 'File Storage Item ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return StudentRecordToFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentRecordToFileQuery(get_called_class());
    }
}
