<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use common\validators\JsonValidator;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_menu".
 *
 * @property integer $id
 * @property string $key
 * @property string $title
 * @property string $items
 * @property integer $status
 */
class WidgetMenu extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;

    //页脚分类
    const FOOTER_CATEGORY = 'category_footer';
    //联系我们
    const FOOTER_CONTACT  = 'category_contact';

    public $label;
    public $url;
    public $sort;

    //存放items解析后的值(数组)
    public $body;//页脚内容

     //联系我们额外属性
    public $contact = [
            'telephone'=>'telephone',
            'address'  =>'address',
            'zip_code' =>'zip_code',
            'child_address'=>'child_address',
            'child_code'   =>'child_code'
    ];
    //其他页脚额外属性
    public $footer_label = [
            'label'=>'label',
            'url'  =>'url',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_menu}}';
    }

    public function behaviors()
    {
        return [
            'cacheInvalidate' => [
                'class' => CacheInvalidateBehavior::className(),
                'cacheComponent' => 'frontendCache',
                'keys' => [
                    function ($model) {
                        return [
                            get_class($model),
                            $model->key
                        ];
                    }
                ]
            ],
            //默认生成key
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'key',
                'immutable' => false,
            ],

        ];
    }
    public function attributes(){

        return  ArrayHelper::merge(
            parent::attributes(),
            $this->contact,
            $this->footer_label
        );

    }

    /**
     * @inheritdoc
     */
     // public $telephone ;
     // public $address;
     // public $zip_code;
     // public $child_address;
     // public $child_code;
    public function rules()
    {
        return [
            [['title', 'items'], 'required'],
            [['key'], 'unique'],
            [['items'], JsonValidator::className()],
            [['status'], 'integer'],
            [['key'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 255],
            [['url','label'],'safe','on'=>'footer'],
            [['telephone','address','body','zip_code','child_address','child_code'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('common', 'ID'),
            'key'   => Yii::t('common', 'Key'),
            'title' => Yii::t('common', 'Title'),
            'items' => Yii::t('common', 'Config'),
            'url'   => Yii::t('common', '跳转路径'),
            'label' => Yii::t('common', '标签'),
            'telephone'  => Yii::t('common','联系电话'),
            'address'  => Yii::t('common','总公司地址'),
            'zip_code'  => Yii::t('common','邮编'),
            'child_address'  => Yii::t('common','子公司地址'),
            'child_code'  => Yii::t('common','子公司邮编'),
            'sort'  => Yii::t('common','排序'),
            'status' => Yii::t('common', 'Status')
        ];
    }

    //解析items,并赋值给对应属性
    public function getArrayItems(){
        $items = [];
        if(json_decode($this->items,true)){
            $this->body = json_decode($this->items,true);
        }
    }
    //items赋值
    public function getJsonItems(){
        $this->items = json_encode($this->body);
    }
}
