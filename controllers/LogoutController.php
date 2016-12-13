<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class LogoutController extends Controller
{

    //登陆控制
	public function actionLogout()
	{
		Yii::$app->user->logout();

        return $this->goHome();
	}

}

?> 