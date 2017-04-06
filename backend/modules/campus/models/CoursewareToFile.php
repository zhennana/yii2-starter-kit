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
          return $this->music($model);
        }
        elseif ($category_slug == 'book') {
          return $this->book($model);
        }
        
        return [];
      }

      public function music($model)
      {
        $info = [];
        foreach ($model as $key => $value) {
            $index = (int)$value['courseware_id'];
            $info[$index]['music_id'] = $value['courseware_id'];
            $info[$index]['title']    = $value['title'];
            $info[$index]['lyric']     = $value['body'];
            foreach ($value->toFile as $k => $v) {
                
                if(in_array($v->fileStorageItem->type,['image/jpeg','image/png'])){
                  $info[$index]['banner_src'] = $v->fileStorageItem->url.$v->fileStorageItem->file_name;
                }else{
                  $info[$index]['banner_src'] = '';
                }
                
                if(in_array($v->fileStorageItem->type,['audio/mpeg'])){
                  $info[$index]['music_src'] =  $v->fileStorageItem->url.$v->fileStorageItem->file_name;
                }else{
                  $info[$index]['video_src'] = '';
                }
            }
        }
        return $info;
      }
 
      public function book($model)
      {
        $info = [];
        foreach ($model as $key => $value) {
            $index = (int)$value['courseware_id'];
            $info[$index]['book_id'] = $value['courseware_id'];
            $info[$index]['title']    = $value['title'];
            $info[$index]['lyric']     = $value['body'];
            if($value->toFile){
              foreach ($value->toFile as $k => $v) {
                  if(in_array($v->fileStorageItem->type,['image/jpeg','image/png'])){
                    $info[$index]['banner_src'] = $v->fileStorageItem->url.$v->fileStorageItem->file_name;
                    $info[$index]['img_src'][]  = $v->fileStorageItem->url.$v->fileStorageItem->file_name;
                  }
                  if(isset($info[$index]['img_src']) && empty($info[$index]['img_src'])){
                      $info[$index]['img_src'][]  ='';
                  }
              }
            }else{
              $info[$index]['banner_src'] =  '';
              $info[$index]['img_src'][]   =  '';
            }
        }
        return $info;


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
              $info[$index]['banner_src'] = $v->fileStorageItem->url.$v->fileStorageItem->file_name;
            }else{
              $info[$index]['banner_src'] = 'http://omsqlyn5t.bkt.clouddn.com/mistake02.jpg';
              
            }

            if(in_array($v->fileStorageItem->type,['video/ogg','video/mp4'])){
              $info[$index]['video_src'] = $v->fileStorageItem->url.$v->fileStorageItem->file_name;
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
