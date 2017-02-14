<?php

namespace common\models\grade;

use Yii;

/**
 * This is the model class for table "{{%grade_profile}}".
 *
 * @property integer $grade_id
 * @property integer $grade_storage_space
 * @property integer $student_sum
 * @property integer $teacher_sum
 * @property integer $article_sum
 * @property integer $page_sum
 * @property integer $album_sum
 * @property integer $levels
 *
 * @property Grade $grade
 */
class GradeProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grade_profile}}';
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
            [['grade_storage_space', 'student_sum', 'teacher_sum', 'article_sum', 'page_sum', 'album_sum', 'levels'], 'integer'],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::className(), 'targetAttribute' => ['grade_id' => 'grade_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grade_id' => Yii::t('common', 'Grade ID'),
            'grade_storage_space' => Yii::t('common', '班级存储配额'),
            'student_sum' => Yii::t('common', '学生总人数'),
            'teacher_sum' => Yii::t('common', '老师总人数'),
            'article_sum' => Yii::t('common', 'Article Sum'),
            'page_sum' => Yii::t('common', 'Page Sum'),
            'album_sum' => Yii::t('common', 'Album Sum'),
            'levels' => Yii::t('common', '班级级别'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrade()
    {
        return $this->hasOne(Grade::className(), ['grade_id' => 'grade_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\GradeProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GradeProfileQuery(get_called_class());
    }
}
