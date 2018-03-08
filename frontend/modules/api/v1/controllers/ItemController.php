<?php

namespace frontend\modules\api\v1\controllers;

/**
* This is the class for REST controller "ItemController".
*/
use Yii;
use yii\helpers\Url;
use yii\base\Model;
use yii\data\ActiveDataProvider;
// use ecommon\components\ArrayDataProvider;
//use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

use yii\rest\Controller;
use \yii\rest\ActiveController;
use \backend\modules\campus\models\Courseware;
use \backend\modules\campus\models\CoursewareCategory;
use \backend\modules\campus\models\CoursewareToFile;
use \backend\modules\campus\models\CoursewareToCourseware;


class ItemController extends \yii\rest\ActiveController
{
    public $modelClass = '\backend\modules\campus\models\Courseware';

    /**
     * @var array
     */
    public $serializer = [
        'class' => 'common\rest\Serializer',    // 返回格式数据化字段
        'collectionEnvelope' => 'result',       // 制定数据字段名称
        // 'errno' => 0,                           // 错误处理数字
        'message' => 'OK',                      // 文本提示
    ];

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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
                        'Origin' => ['http://localhost', 'https://*.doamin.com'],
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
     *     tags={"500-Item-首页、视频、音乐、绘本接口"},
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
        
        $all = CoursewareCategory::find()->all();
        $info = [];
        foreach ($all as $key => $value) {
            $info[$value->slug]['title'] = $value->name;
            $info[$value->slug]['banner_src'] = $value->banner_src;
            $info[$value->slug]['description'] = $value->description;
            $info[$value->slug]['classify'] = $value->name;
            $info[$value->slug]['classify_id'] = $value->category_id;
        }
        $info['suggest'] = [
            1 => ['id'=>1, 'keywords'=> '热门视频'],
            2 => ['id'=>2, 'keywords'=> '幼苗'],
            3 => ['id'=>3, 'keywords'=> '小树'],
            4 => ['id'=>4, 'keywords'=> '大树'],
        ];
        /*
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
        ];*/
        return $info;
    }

    /**
     * @SWG\Get(path="/item/list-video",
     *     tags={"500-Item-首页、视频、音乐、绘本接口"},
     *     summary="视频产品列表",
     *     description="返回视频列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "category_id",
     *        description = "分类ID",
     *        required = false,
     *        default = 1,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "tags",
     *        description = "suggest标签的关键词，多关键词半角逗号隔开",
     *        required = false,
     *        default = "热门视频",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success,返回视频数据"
     *     ),
     * )
     *
     */
    public function actionListVideo($category_id = 1, $tags='热门视频')
    {
        $course = new CoursewareToFile();

        $data = $course->courseware('video',$category_id);
        return $data;
        //var_dump($data); exit();
        /*
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
        $info = [];
        for ($i=1; $i < 26 ; $i++) { 
            $info[$i] = [
                'video_id' => $i ,
                'title'=>'Abc Song   Super Simple Songs',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                //'video_src' => 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv',
                'video_src' => ($i%2)? 'http://omsqlyn5t.bkt.clouddn.com/0.mp4' : 'http://omsqlyn5t.bkt.clouddn.com/test.mp4',
            ];
        }

        return $info;*/
    }

    /**
     * @SWG\Get(path="/item/list-music",
     *     tags={"500-Item-首页、视频、音乐、绘本接口"},
     *     summary="音乐产品列表",
     *     description="返回音乐列表",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "category_id",
     *        description = "分类ID",
     *        required = false,
     *        default = 2,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "tags",
     *        description = "suggest标签的关键词，多关键词半角逗号隔开",
     *        required = false,
     *        default = "幼苗",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success,返回音乐数据"
     *     ),
     * )
     *
     */
    public function actionListMusic($category_id = 2, $tags='幼苗')
    {
        $course = new CoursewareToFile();

        $data = $course->courseware('music',$category_id);
        return $data;
        // $info = [
        //     1=>[
        //         'music_id' =>1 ,
        //         'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
        //         'lyric' => '这是歌词',
        //         'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
        //         'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
        //     ],
        //     2=>[
        //         'music_id' =>2 ,
        //         'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
        //         'lyric' => '这是歌词',
        //         'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
        //         'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
        //     ],
        //     3=>[
        //         'music_id' =>3 ,
        //         'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
        //         'lyric' => '这是歌词',
        //         'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
        //         'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
        //     ],
        //     4=>[
        //         'music_id' =>4 ,
        //         'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
        //         'lyric' => '这是歌词',
        //         'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
        //         'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
        //     ],
        //     5=>[
        //         'music_id' =>5 ,
        //         'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
        //         'lyric' => '这是歌词',
        //         'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
        //         'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
        //     ],
        //     6=>[
        //         'music_id' =>6 ,
        //         'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
        //         'lyric' => '这是歌词',
        //         'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
        //         'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
        //     ],
        // ];

        // $info = [];
        // for ($i=1; $i < 26 ; $i++) { 
        //     $info[$i] = [
        //         'music_id' => $i ,
        //         'title'=>'Happy Birthday,Danny and the DinosaurTrack01',
        //         'lyric' => '这是歌词',
        //         'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
        //         'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/01.Happy%20Birthday,Danny%20and%20the%20DinosaurTrack01.MP3',
        //     ];
        // }

        //return $info;
    }

    /**
     * @SWG\Get(path="/item/list-book",
     *     tags={"500-Item-首页、视频、音乐、绘本接口"},
     *     summary="绘本产品列表",
     *     description="返回绘本列表",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "category_id",
     *        description = "分类ID",
     *        required = false,
     *        default = 3,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "tags",
     *        description = "suggest标签的关键词，多关键词半角逗号隔开",
     *        required = false,
     *        default = "小树",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success,返回绘本数据"
     *     ),
     * )
     *
     */
    public function actionListBook($category_id = 3, $tags='小树')
    {
        $course = new CoursewareToFile();

        $data = $course->courseware('book',$category_id);
        return $data;
        
       /* $info = [
            1=>[
                'book_id' =>1 ,
                'title'=>'A Big Mistake',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake.mp3',
                'img_src'   => [
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01a.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake03.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake04.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake05.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake06.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake07.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake08.jpg',
                ],
            ],
            2=>[
                'book_id' =>2 ,
                'title'=>'A Big Mistake',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake.mp3',
                'img_src'   => [
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01a.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake03.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake04.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake05.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake06.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake07.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake08.jpg',
                ],
            ],
            3=>[
                'book_id' =>3 ,
                'title'=>'A Big Mistake',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake.mp3',
                'img_src'   => [
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01a.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake03.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake04.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake05.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake06.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake07.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake08.jpg',
                ],
            ],
            4=>[
                'book_id' =>4 ,
                'title'=>'A Big Mistake',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake.mp3',
                'img_src'   => [
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01a.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake03.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake04.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake05.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake06.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake07.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake08.jpg',
                ],
            ],
            5=>[
                'book_id' =>5 ,
                'title'=>'A Big Mistake',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake.mp3',
                'img_src'   => [
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01a.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake03.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake04.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake05.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake06.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake07.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake08.jpg',
                ],
            ],
            6=>[
                'book_id' =>6 ,
                'title'=>'A Big Mistake',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake.mp3',
                'img_src'   => [
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01a.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake03.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake04.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake05.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake06.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake07.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake08.jpg',
                ],
            ],
        ];
        $info = [];
        for ($i=1; $i < 26 ; $i++) {
            # code...
            $info[$i] =[
                'book_id' => $i ,
                'title'=>'A Big Mistake',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'music_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake.mp3',
                'img_src'   => [
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake01a.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake03.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake04.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake05.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake06.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake07.jpg',
                    'http://omsqlyn5t.bkt.clouddn.com/mistake08.jpg',
                ],
            ];
        }
    
        return $info;*/
    }


}
