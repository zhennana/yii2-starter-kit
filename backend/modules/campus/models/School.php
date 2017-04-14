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
