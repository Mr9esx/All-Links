<?php

namespace app\models;

use yii\base\Model;

class CaptchaCode extends Model
{

	public $code;

	public function rules()
	{
		return [
			['code', 'required' , 'message' => '验证码不能为空！' ],
	        [ 'code' , 'captcha' , 'captchaAction' => 'captcha/captcha' , 'message' => '验证码错误！' ],
		];
	}

}

?>