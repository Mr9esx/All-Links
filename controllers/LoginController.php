<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\CaptchaCode;

class LoginController extends Controller
{

	/*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?','@'],
                    ],
                ],
            ],
        ];
    }*/

    //登陆控制
	public function actionLogin()
	{
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$login_model = new LoginForm();
		$captcha = new CaptchaCode();
		if (Yii::$app->request->isPost && $login_model->load(Yii::$app->request->post())){
			/*
			把验证码检验提取出来，可以保证即使验证码错误，用户名都不需要重新输入。
			 */
			if ($captcha->load(Yii::$app->request->post()) && $captcha->validate() && $login_model->login()){
				var_dump(Yii::$app->request->post());
				$this->goHome();
			}
			else{
				$login_model->load(Yii::$app->request->post());
				$login_model -> password = '';
				/*
				清掉上次验证码的输入
				 */
				$captcha -> code = '';
				return $this->renderPartial('login',[ 'model' => $login_model , 'captcha' => $captcha ]);
			}
		}
		/*echo Yii::$app->getSession()->getFlash('success');*/
		return $this->renderPartial('login',[ 'model' => $login_model , 'captcha' => $captcha ]);
	}

}

?>
