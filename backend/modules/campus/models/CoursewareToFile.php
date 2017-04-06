<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CoursewareToFile as BaseCoursewareToFile;
use yii\helpers\ArrayHelper;

use \backend\modules\campus\models\Courseware;
use \backend\modules\campus\models\CoursewareCategory;
use \backend\modules\campus\models\CoursewareToFile;
use \backend\modules\campus\models\CoursewareToCourseware;

/**
 * This is the model class for table "courseware_to_file".
 */
class CoursewareToFile extends BaseCoursewareToFile
{

  public function behaviors()
      {
          return ArrayHelper::merge(
              parent::behaviors(),
              [
                  # custom behaviors
              ]
          );
      }

      public function rules()
      {
          return ArrayHelper::merge(
               parent::rules(),
               [
                    # custom validation rules
               ]
          );
      }

      public function courseware($category_slug, $category_id){
        $model = $this->getCoursewareById($category_id);

        if($category_slug == 'video'){
          return $this->video($model);
        }
        elseif ($category_slug == 'music') {
          # code...
        }
        elseif ($category_slug == 'book') {
          # code...
        }
        
        return [];
      }

      public function music()
      {

      }

      public function book()
      {

      }


      /*
        1=>[
                'video_id' =>1 ,
                'title'=>'Abc Song   Super Simple Songs',
                'banner_src' => 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg',
                'video_src' => 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv',
            ],
      */
      public function video($model){
        $info = [];
        foreach ($model as $key => $value) {
          $index = intval($value->courseware_id);
          $info[$index]['video_id'] = $value->courseware_id;
          $info[$index]['title'] = $value->title;
          $info[$index]['body'] = $value->body;
          //var_dump($value->toFile); // ->getToFile()->getFileStorageItem()
          foreach ($value->toFile as $k => $v) {
            //var_dump($v->fileStorageItem->type);
            if(in_array($v->fileStorageItem->type,['image/jpeg','image/png'])){
              $info[$index]['banner_src'] = $v->fileStorageItem->url.$v->fileStorageItem->original;
            }else{
              $info[$index]['banner_src'] = 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg';
              
            }

            if(in_array($v->fileStorageItem->type,['image/jpeg','image/png'])){
              $info[$index]['video_src'] = $v->fileStorageItem->url.$v->fileStorageItem->original;
            }else{
              $info[$index]['video_src'] = 'http://omsqlyn5t.bkt.clouddn.com/Abc%20Song%20%20%20Super%20Simple%20Songs%20480P.ogv';
            }

          }
        }

        return $info;
      }

      public function getCoursewareById($category_id){
          return Courseware::find()->where(['category_id'=>$category_id,'status'=>Courseware::COURSEWARE_STATUS_VALID])->all();
      }





}
