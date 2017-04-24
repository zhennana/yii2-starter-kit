<?php

namespace backend\modules\campus\models;

use Yii;
use yii\helpers\ArrayHelper;
use \backend\modules\campus\models\base\School as BaseSchool;
use backend\modules\campus\models\CnCity;
use backend\modules\campus\models\CnProvince;
use backend\modules\campus\models\CnRegion; 

/**
 * This is the model class for table "school".
 */
class School extends BaseSchool
{

    /**
     * 模型返回添加数据,并改变数据类型
     * @return [type] [description]
     */
    public function fields()
    {
       return ArrayHelper::merge(
             parent::fields(),
             [

                'parent_school_title'   => function($model){
                    return isset($model->school->school_title) ? $model->school->school_title : '' ;
                },
                'region' =>function($model){
                    return isset($model->region->region_name) ? $model->region->region_name :  '';
                },
                'city' => function($model){
                    return isset($model->city->city_name) ? $model->city->city_name : '';
                },
                'province' => function($model){
                    return isset($model->province->province_name) ?$model->province->province_name : '';
                },
                'status_label' => function($model){
                    return  self::getStatusValueLabel($model->status);
                },
                'updated_at' => function($model){
                    return date('Y-m-d H:i:s',$model->updated_at);
                },
                'created_at' => function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
             ]
        );
    }
	public function getAddresslist($typeid = 0,$id = 0){
        if($typeid == 1){
            $city    = CnCity::find()->select(['city_id','city_name'])->where(['province_id'=>$id])->all();
            return $city;
            
            //return  ArrayHelper::map($region, 'region_id', 'region_name');
        }
        if($typeid == 2){
            $region  = CnRegion::find()->select(['region_id','region_name'])->where(['city_id'=>$id])->all();
            return $region;
            //return  ArrayHelper::map($city, 'city_id', 'city_name');
        }
        
        $province = CnProvince::find()->all();
        return $province;
        //return  ArrayHelper::map($province, 'province_id', 'province_name');     
    }
    /**
     * 下拉框 数据
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function DropDownGather(){
       $data =[];
       $data['school'] = $this->DropDownSchool();
       $data['status'] = $this->DropDownStatus();
       return $data;
    }
    /**
     * 状态
     */
    public function DropDownStatus(){
      $label = self::optsStatus();
      $data = [];
      foreach ($label as $key => $value) {
          $data[$key]['status_id'] = $key;
          $data[$key]['status_label'] = $value;
      }
      sort($data);
      return $data;
    }

    /**
     * 顶级学校
     */
    public function DropDownSchool(){
         return  School::find()->select(['school_id','school_title'])
                        ->andwhere(['parent_id'=>'0','status'=>School::SCHOOL_STATUS_OPEN])
                        ->asArray()->all();
    }

}
