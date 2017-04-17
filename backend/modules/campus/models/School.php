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
 * 模型返回添加数据
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
            $region  = CnRegion::find()->where(['city_id'=>$id])->asArray()->all();
           	return $region;
            //return  ArrayHelper::map($region, 'region_id', 'region_name');
        }
        if($typeid == 2){
            $city    = CnCity::find()->where(['province_id'=>$id])->asArray()->all();
            return $city;
            //return  ArrayHelper::map($city, 'city_id', 'city_name');
        }
        
        $province = CnProvince::find()->asArray()->all();
        return $province;
        //return  ArrayHelper::map($province, 'province_id', 'province_name');
           
    }
}
