<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\CaptchaCode;

class CaptchaController extends Controller
{

	//验证码
	public function actions()
	{
		return [
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'maxLength' => 4,
				'minLength' => 4,
				'width' => 120,
				'height' => 35,
			],
		];
	}
	
}

?>