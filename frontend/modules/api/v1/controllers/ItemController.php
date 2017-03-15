<?php

namespace frontend\modules\api\v1\controllers;

/**
* This is the class for REST controller "ItemController".
*/
use Yii;
use yii\helpers\Url;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ecommon\components\ArrayDataProvider;
//use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

use yii\rest\Controller;
use \yii\rest\ActiveController;

use ecommon\models\item\Item;
use ecommon\models\search\ItemSearch;
use ecommon\models\item\ItemSku;
use ecommon\models\search\ItemSkuSearch;

use ecommon\models\item\Category;
use ecommon\models\search\CategorySearch;

use ecommon\models\recommend\SearchHotKeyword;

use ecommon\models\user\UserAccount;
use ecommon\models\item\Store;
use ecommon\models\cart\Cart;
use ecommon\components\Area;

class ItemController extends \yii\rest\ActiveController
{
    public $modelClass = 'ecommon\models\item\Item';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        //Yii::$app->controller->detachBehavior('access');
        return $action;
    }

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return true;
                            return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
                        ]
                    ]
                ],
                'corsFilter' => [
                    'class' => \yii\filters\Cors::className(),
                    'cors' => [
                        // restrict access to
                        'Origin' => ['http://localhost', 'https://*.yajol.com'],
                        'Access-Control-Request-Method' => ['POST', 'PUT', 'GET'],
                        // Allow only POST and PUT methods
                        'Access-Control-Request-Headers' => ['X-Wsse'],
                        // Allow only headers 'X-Wsse'
                        'Access-Control-Allow-Credentials' => true,
                        // Allow OPTIONS caching
                        'Access-Control-Max-Age' => 3600,
                        // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                        'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                        ],
                ],
            ]
        );
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    /**
     * @SWG\Get(
     *     path="/item/index",
     *     tags={"500-Item-商品、音频、视频、图片接口"},
     *     summary="首页内容",
     *     description="返回首页三个产品信息",
     *     produces={"application/xml"},
     *     
     *     @SWG\Response(
     *         response = 200,
     *         description = " success"
     *     )
     * )
     *
     */
    public function actionIndex(){
        $info = [];
        $info = [
            'video' => [
                'title'=>'视频',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'description' => '可选视频描述',
                'classify' => '视频',
                'classify_id' => 1,
            ],
            'music' => [
                'title'=>'音乐',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'description' => '可选音乐描述',
                'classify' => '音乐',
                'classify_id' => 2,
            ],
            'books' => [
                'title'=>'绘本',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'description' => '可选绘本描述',
                'classify' => '绘本',
                'classify_id' => 3,
            ],
            'suggest' => [
                1 => ['id'=>1, 'keywords'=> '热门视频'],
                2 => ['id'=>2, 'keywords'=> '三岁以下'],
                3 => ['id'=>3, 'keywords'=> '4-5岁'],
                4 => ['id'=>4, 'keywords'=> '6-7岁'],
            ],
        ];
        return $info;
    }

    /**
     * @SWG\Get(path="/item/list-video",
     *     tags={"500-Item-商品、音频、视频、图片接口"},
     *     summary="视频产品列表",
     *     description="返回视频列表",
     *     produces={"application/json"},
     *     
     *     @SWG\Response(
     *         response = 200,
     *         description = "success,返回视频数据"
     *     ),
     * )
     *
     */
    public function actionListVideo()
    {
        $info = [
            1=>[
                'video_id' =>1 ,
                'title'=>'Abc Song   Super Simple Songs',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'video_src' => 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv',
            ],
            2=>[
                'video_id' =>2 ,
                'title'=>'Abc Song   Super Simple Songs',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'video_src' => 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv',
            ],
            3=>[
                'video_id' =>3 ,
                'title'=>'Abc Song   Super Simple Songs',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'video_src' => 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv',
            ],
            4=>[
                'video_id' =>4 ,
                'title'=>'Abc Song   Super Simple Songs',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'video_src' => 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv',
            ],
            5=>[
                'video_id' =>5 ,
                'title'=>'Abc Song   Super Simple Songs',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'video_src' => 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv',
            ],
            6=>[
                'video_id' =>6 ,
                'title'=>'Abc Song   Super Simple Songs',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'video_src' => 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv',
            ],
        ];

        return $info;
    }

    /**
     * @SWG\Get(path="/item/list-music",
     *     tags={"500-Item-商品、音频、视频、图片接口"},
     *     summary="音乐产品列表",
     *     description="返回音乐列表",
     *     produces={"application/xml"},
     *     
     *     @SWG\Response(
     *         response = 200,
     *         description = "success,返回音乐数据"
     *     ),
     * )
     *
     */
    public function actionListMusic()
    {
        $info = [
            1=>[
                'music_id' =>1 ,
                'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
                'lyric' => '这是歌词',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
            ],
            2=>[
                'music_id' =>2 ,
                'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
                'lyric' => '这是歌词',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
            ],
            3=>[
                'music_id' =>3 ,
                'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
                'lyric' => '这是歌词',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
            ],
            4=>[
                'music_id' =>4 ,
                'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
                'lyric' => '这是歌词',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
            ],
            5=>[
                'music_id' =>5 ,
                'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
                'lyric' => '这是歌词',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
            ],
            6=>[
                'music_id' =>6 ,
                'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
                'lyric' => '这是歌词',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
            ],
        ];

        return $info;
    }

    /**
     * @SWG\Get(path="/item/sku-info",
     *     tags={"500-Item-商品、音频、视频、图片接口"},
     *     summary="商品SKU 价格 运费 库存",
     *     description="返回商品价格 运费 库存",
     *     produces={"application/json"},
     *
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "item_id",
     *        description = "商品item_id 4",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "symbol",
     *        description = "symbol从小到大半角逗号间隔：1,4,7",
     *        required = true,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "client_type",
     *        description = "toc:100 或者 tob:200 ",
     *        required = false,
     *        type = "string",
     *        default = 100,
     *        enum = {100,200},
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "store_id_default",
     *        description = "用户默认店铺",
     *        required = false,
     *        default = 1,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "level",
     *        description = "用户等级",
     *        required = false,
     *        default = 10,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Response(
     *         response = 200,
     *         description = "success"
     *     ),
     * )
     *
     */
    public function actionSkuInfo($item_id, $symbol,$client_type = 100, $store_id_default = 1, $level = 10){
        return ItemSku::find()->where([
            'item_id'   =>intval($item_id),
            'attr_symbol_path' => $symbol
        ])->all();
    }

    /**
     * @SWG\Get(path="/item/suggest",
     *     tags={"500-Item-商品、音频、视频、图片接口"},
     *     summary="搜索建议接口",
     *     description="返回商品搜索词",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "keyword",
     *        description = "关键词",
     *        required = true,
     *        default = "牛",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "schema",
     *        description = "模式",
     *        required = true,
     *        type = "string",
     *        enum = {"left", "mixture"}
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "client_type",
     *        description = "toc:100 或者 tob:200 ",
     *        required = false,
     *        type = "string",
     *        default = 100,
     *        enum = {100,200},
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "store_id_default",
     *        description = "用户默认店铺",
     *        required = false,
     *        default = 1,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "level",
     *        description = "用户等级",
     *        required = false,
     *        default = 10,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Response(
     *         response = 200,
     *         description = "success"
     *     ),
     * )
     *
     */
    public function actionSuggest($keyword,$schema='left',$client_type = 100, $store_id_default = 1, $level = 10){
    	$keyword = trim($keyword);
        return SearchHotKeyword::find()->select([
        	'keywords',
        	'trend_counts',
        	'sku_count',
        	])->where([
        	'or',
            ['like', 'keywords'  , $keyword],
        ])->all();
    }

    /**
     * @SWG\Get(path="/item/hot-words",
     *     tags={"500-Item-商品、音频、视频、图片接口"},
     *     summary="热词",
     *     description="返回商品搜索词",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "limit",
     *        description = "个数",
     *        required = false,
     *        default = 20,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "client_type",
     *        description = "toc:100 或者 tob:200 ",
     *        required = false,
     *        type = "string",
     *        default = 100,
     *        enum = {100,200},
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "store_id_default",
     *        description = "用户默认店铺",
     *        required = false,
     *        default = 1,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "level",
     *        description = "用户等级",
     *        required = false,
     *        default = 10,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Response(
     *         response = 200,
     *         description = "success"
     *     ),
     * )
     *
     */
    public function actionHotWords($limit=20,$client_type = 100, $store_id_default = 1, $level = 10){
        return SearchHotKeyword::find()->select([
	    	'keywords',
	    	'trend_counts',
	    	'sku_count',
    	])
    	->orderBy('trend_counts DESC,sku_count DESC,updated_at DESC')
    	->limit($limit)
    	->all();
    }

    /**
     * @SWG\Get(path="/item/search",
     *     tags={"500-Item-商品、音频、视频、图片接口"},
     *     summary="搜索",
     *     description="返回商品列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "keyword",
     *        description = "关键词",
     *        required = true,
     *        default = "牛",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "schema",
     *        description = "模式",
     *        required = false,
     *        type = "string",
     *        default = "mixture",
     *        enum = {"left", "mixture"}
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "client_type",
     *        description = "toc:100 或者 tob:200 ",
     *        required = false,
     *        type = "string",
     *        default = 100,
     *        enum = {100,200},
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "store_id_default",
     *        description = "用户默认店铺",
     *        required = false,
     *        default = 1,
     *        type = "string"
     *     ),
     *     
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "level",
     *        description = "用户等级",
     *        required = false,
     *        default = 10,
     *        type = "string"
     *     ),
    *     @SWG\Parameter(
     *        in = "query",
     *        name = "longitude",
     *        description = "经度",
     *        required = false,
     *        default = 116.786049,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "latitude",
     *        description = "纬度",
     *        required = false,
     *        default = 39.952518,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success"
     *     ),
     * )
     *
     */
    public function actionSearch($keyword,$schema='left',$limit=20,$client_type = 0, $store_id_default = 0, $level = 10,$longitude=false,$latitude= false){
       //根据这个值判断是否展示商品。
       $params = [];
        $is_store_id = true;
        if($longitude && $latitude && $client_type == 100 && !$store_id_default){
                $area = new Area(store_scope(),$longitude,$latitude);
                // $store_scope = store_scope();
                // $area = new Area($store_scope,$longitude,$latitude);
            if(!empty($area->checkPoint())){
                $store_list = $area->checkPoint();
                $store_model= Store::find()
                            ->where(['store_id'=>$store_list])
                            ->andWhere(['status' => Store::STATUS_OPEN]) // Store::STATUS_OPEN,
                            ->andWhere(['NOT',['store_id'=> UserAccount::STORE_ID_DEFAULT_TOB ]])
                            ->all();
                    $store_id  = Store::store_sort($store_model,$longitude, $latitude);
                   if(isset($store_id['store_default'])){
                        $store_id_default = $store_id['store_default']->store_id;
                   }else{
                     $is_store_id = false;
                   }
              }else{
                $is_store_id = false;
              }
        }
        /**
         * 经过经纬度匹配，没有返回空。
         */
        if(!$is_store_id){
           return new ArrayDataProvider([
             'allModels' => $params
            ]);
        }
        if(!$store_id_default && !Yii::$app->user->isGuest){
            $store_id_default = Yii::$app->user->identity->getUserAccountField('store_id_default');
        }else{
              // 设置 To C 专店
            if($client_type == UserAccount::CLIENT_TYPE_TOC &&  $store_id_default == UserAccount::STORE_ID_DEFAULT_TOB){
                $store_id_default = UserAccount::STORE_ID_DEFAULT_TOC;
            }
        }
//var_DumP($store_id_default);exit;
        if(!$store_id_default){
            $store_id_default = Store::DEFAULT_STORE_ID;
        }

        if(!$client_type){
            if(Yii::$app->user->isGuest){
                $client_type = UserAccount::CLIENT_TYPE_TOC;
            }else{
                $client_type = Yii::$app->user->identity->getUserAccountField('client_type');
            }
        }
        // 设置 To B 专店
        if($client_type == UserAccount::CLIENT_TYPE_TOB){
            $store_id_default = UserAccount::STORE_ID_DEFAULT_TOB;
        }

/*
        //var_Dump($a ,!$a );exit;
        if($client_type == UserAccount::CLIENT_TYPE_TOC &&
          store_item($store_id_default) != 1){
                $params = [];
               return new ArrayDataProvider([
                'allModels' => $params
            ]);
         }
*/
    	$keyword = trim($keyword);
    	$hash = md5($keyword);
    	$model = SearchHotKeyword::find()->where([
    		'hash' => $hash,
    	])->one();
    	if($model){
    		$model->trend_counts ++;
    		$model->save();
    	}else{
    		$SearchHoKeywordsModel = new SearchHotKeyword();
	    	$SearchHoKeywordsModel->keywords = $keyword;
	    	$SearchHoKeywordsModel->hash = md5($keyword);
	    	$SearchHoKeywordsModel->trend_counts ++;
	    	$SearchHoKeywordsModel->save(false);
    	}

        $data =  ItemSku::find()->select(['*'])
        ->from('item_sku as s ')
        ->leftJoin('item as i', 's.item_id = i.item_id')
        ->where([
        	'or',
        	['like', 's.item_sku_title' , $keyword],
            ['like', 'i.title'   		, $keyword],
            //['like', 'i.description' 	, $keyword]
        ])
        //->limit($limit)
        ->andWhere(['NOT','s.price'=>0.00])
        ->andWhere(['s.type'=> $client_type])
        ->andWhere(['i.status'=> Item::STATUS_PUTWAY])
        ->andWhere(['s.status'=>ItemSku::STATUS_OPEN])
        ->andWhere(['s.is_default'=>ItemSku::IS_DEFAULT_SHOW])
        ->andWhere(['s.store_id'=>$store_id_default])
        ->with(['storage','productValues','store'])
        ->asArray()
        ->all();
        //$item = new Item;
        //$data = $item->formatSkuApi($data);
        $params = [];
        $imgszie = '?imageView2/1/w/300/h/300';
        $defaultImg = 'http://7xsm8j.com2.z0.glb.qiniucdn.com/defaultImage.jpg?imageView2/1/w/300/h/300';
        foreach ($data as $key => $value) {

           //获取sku_value值
           $value['productValues']  = ArrayHelper::index($value['productValues'],'symbol');
           $temp_name = [];
           foreach (explode(',',$value['attr_symbol_path']) as $k1 => $v1) {
                $temp_name[] =  isset($value['productValues'][$v1]['attr_value']) ? $value['productValues'][$v1]['attr_value'] : '';
            }
            $temp_name= join(" ",$temp_name);

            //获取商品详情地址
            $target   =
                Yii::$app->request->hostInfo.Url::to([
                    'item/detail',
                    'items'=>$value['item_id'],
                    'sku_id'=>$value['sku_id'],
                    'symbol_path'=>$value['attr_symbol_path'],
            ]);
            $dataurl = [];
            //获取图片。
            foreach($value['storage'] as $k2 => $v2 ){
                $dataurl[] = $v2['base_url'].$v2['path'].$imgszie;
            }
            $image_url  = empty($dataurl) ? [$defaultImg] : $dataurl ;

            $params[$key]       =[
                                    'sku_id'                => $value['sku_id'],
                                    'sku_value'             => $temp_name,
                                    'images_url'            => $image_url,
                                    'target_url'            => $target,
                                    'store_id'              => $value['store_id'],
                                    'store_title'           => $value['store']['title'],
                                    'category_id'           => $value['category_id'],
                                    'item_id'               => $value['item_id'],
                                    'item_sku_title'        => $value['item_sku_title'],
                                    'attr_symbol_path'      => $value['attr_symbol_path'],
                                    'price'                 => $value['price'],
                                    'price_original'        => $value['price_original'],
                                    'cost'                  => $value['cost'],
                                    'freight'               => $value['freight'],
                                    'stock'                 => $value['stock'],
                                    'is_default'            => $value['is_default'],
                                    'status'                => $value['status'],
                                    'type'                  => $value['type'],
                                    'image_count'           => $value['image_count'],
                                    'item_no'               => $value['item_no'],
                                    'item_barcode'          => $value['item_barcode'],
                                    'is_jinxiaocun'         => $value['is_jinxiaocun'],
                                    'updated_at'            => $value['updated_at'],
                                    'created_at'            => $value['created_at'],
                                    'title'                 => $value['title'],
                                    'subtitle'              => $value['subtitle'],
                                    'description'           => $value['description'],
                                    'is_new'                => $value['is_new'],
                                    'is_hot'                => $value['is_hot'],
                                    'is_promotion'          => $value['is_promotion'],
                                    'is_online_payment'     => $value['is_online_payment'],
                                    'sku_count'             => $value['sku_count'],
                                    //'is_sync'               =>$value['is_sync'],
                                ];
        }
        return new ArrayDataProvider([
            'allModels' => $params
        ]);
    }
    /**
     * @SWG\POST(path="/item/often-buy",
     *     tags={"500-Item-商品、音频、视频、图片接口"},
     *     summary="常购清单",
     *     description="返回商品列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "buyer_id",
     *        description = "用户id",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "erroerno 返回0 正常"
     *     ),
     * )
     *
     */
    public function actionOftenBuy(){

        $data = [
            'errorno'=> '0',
            'message'=>'',
            'data'   =>''
        ];
        $buyer_id = [];
        $store_id = [];

        //获取当前用户的默认店铺。
        if(!Yii::$app->user->isGuest){
            $store_id = Yii::$app->user->identity->getUserAccountField('store_id_default');
        }

        if(isset($_POST['buyer_id']) && !empty($_POST['buyer_id'])){
           $buyer_id = $_POST['buyer_id'];
        }else{
            return $data = [
                        'errorno'=>(string) __LINE__,
                        'message'=>'缺少用户id',
                        'data'   =>[]
                    ];
        }
        $often = Cart::find() 
                ->select(['*'])
                ->from('cart as c ')
                ->leftJoin('item_sku as s','c.sku_id = s.sku_id')
                //->leftJoin('store as d','s.store_id = c.store_id')
                ->groupBy(['c.sku_id'])
                ->having(['c.buyer_id'=>$buyer_id,'c.status'=>Cart::STATUS_ORDER,'s.status'=>ItemSku::STATUS_OPEN])
                ->andhaving(['NOT',['s.stock'=> 0 ]])
                ->andhaving(['c.store_id'=> $store_id])
                //->andhaving(['d.store_id' => Store::STATUS_OPEN])
                ->orderBy(['c.updated_at'=>SORT_DESC])
                ->limit(30)
                //->asArray()
                ->all();
        if(isset($often) && !empty($often)){
            foreach ($often as $key => $value ) {

                if(!isset($value->itemSku) || empty($value->itemSku)){
                    continue;
                }

                $data['data'][$key] = $value->cartDatalic($value->itemSku);
                $data['data'][$key]['count'] = $value->count;
                $data['data'][$key]['item_id'] = $value->item_id;
                $data['data'][$key]['price'] = $value->itemSku->price;
                $data['data'][$key]['price_original'] =$value->itemSku->price_original;
                if($data['data'][$key]['stock'] < $value->count ){
                    $data['data'][$key]['count'] = $data['data'][$key]['stock'];
                }

            }
        }else{
            $data = [
                'errorno'=>(string) __LINE__,
                'message'=>'没有购买过商品',
                'data'   =>[]
            ];
        }
        return $data;
    }

}
