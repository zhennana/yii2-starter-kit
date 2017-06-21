<?php
namespace common\validators;

use yii\validators\Validator;

class PhoneValidator extends Validator
{
    public function init()
    {
        parent::init();
    }

	public function validateAttribute($model, $attribute)
    {
//		parent::validateAttribute($model, $attribute);
		/** Custom Validation Code - This works **/
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
	
	return <<< 'JS'

	var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	
	if (value != '')
	{
		if(!myreg.test(value))
		{
			var myreg2 = /^0(([1-9]\d)|([3-9]\d{2}))\d{8}$/;
			if (!myreg2.test(value))
			{
				var errinfo = '无效手机号！';
				messages.push(errinfo);
			}
		}
	}
JS;

}
}