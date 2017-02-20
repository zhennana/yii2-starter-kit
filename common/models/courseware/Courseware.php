<?php

namespace common\models\courseware;

use Yii;

/**
 * This is the model class for table "{{%courseware}}".
 *
 * @property integer $courseware_id
 * @property integer $category_id
 * @property integer $level
 * @property integer $creater_id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property integer $parent_id
 * @property integer $access_domain
 * @property integer $access_other
 * @property integer $status
 * @property integer $items
 * @property integer $created_at
 * @property integer $updated_at
 */
class Courseware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%courseware}}';
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
            [['category_id', 'level', 'creater_id', 'parent_id', 'access_domain', 'access_other', 'status', 'items', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'title'], 'required'],
            [['body'], 'string'],
            [['slug'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courseware_id' => Yii::t('common', 'Courseware ID'),
            'category_id' => Yii::t('common', '分类'),
            'level' => Yii::t('common', '级别：100课件；200相册；300作品'),
            'creater_id' => Yii::t('common', '创建者'),
            'slug' => Yii::t('common', 'Slug'),
            'title' => Yii::t('common', '标题'),
            'body' => Yii::t('common', '描述json：教学目标'),
            'parent_id' => Yii::t('common', '父课件'),
            'access_domain' => Yii::t('common', '权限：10仅自己可见；20老师；30同学；0所有人'),
            'access_other' => Yii::t('common', '其他权限 1允许分享'),
            'status' => Yii::t('common', 'Status'),
            'items' => Yii::t('common', 'Items'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\CoursrwareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CoursrwareQuery(get_called_class());
    }
}
