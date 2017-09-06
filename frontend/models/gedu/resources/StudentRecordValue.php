<?php

namespace frontend\models\gedu\resources;

use Yii;
use \backend\modules\campus\models\StudentRecordValue as BaseStudentRecordValue;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "student_record_value".
 */
class StudentRecordValue extends BaseStudentRecordValue
{
 public  $_storage_ids = [] ;
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

    public function fields(){
      return ArrayHelper::merge(
          parent::fields(),
          [
            'grade_name'=>function($mdoel){
                return isset($model->grade->grade_name) ? $model->grade->grade_name  : NULL;
            },
            'course_title'=>function($model){
                return isset($model->studentRecordKey->title)? $model->studentRecordKey->title : NULL;
            },
            'full_mark'=>'total_score',
            'images_url'      =>function($model){
                $image = [];
                foreach ($model->studentRecordValueToFile as $key => $value) {
                      $file = isset($value->fileStorageItem) ? $value->fileStorageItem  : null;
                      if($file){
                          $image[] = [
                              'original_url'=>$file->url.$file->file_name.Yii::$app->params['image']['image_original_size'],
                              'shrinkage_url'=>$file->url.$file->file_name.Yii::$app->params['image']['image_shrinkage_size'],
                          ];
                      }
                }
                return $image;
            },
            'target_url'=>function($model){
                return Yii::$app->request->hostInfo.Url::to(['gedu/v1/my/score','grade_id' => $model->grade_id]);
            }

          ]
        );
    }
}
