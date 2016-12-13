<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

use app\models\LoginForm;
use app\models\UserModel;
use app\models\CaptchaCode;

use app\models\User;

class RegisterController extends Controller
{

	/*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }*/

    //注册控制
	public function actionRegister()
	{
		$register_model = new UserModel();
		$register_model->scenario = 'register';
		$captcha = new CaptchaCode();
		if (Yii::$app->request->isPost && $register_model->load(Yii::$app->request->post())){
			/*
			把验证码检验提取出来，可以保证即使验证码错误，用户资料都不需要重新输入。
			 */
			if ($captcha->load(Yii::$app->request->post()) && $captcha->validate() && $register_model->register()){
				$auth = Yii::$app->authManager;
				$role = $auth->getRole('User');
				$auth->assign($role,User::findByUsername($register_model->username)->id ); // 1是test1用户的uid*/
				Yii::$app->getSession()->setFlash('success', '保存成功');
				$this->redirect([ 'login/login' ]);
			}else{
				$login_model = new LoginForm();
				$register_model -> load(Yii::$app->request->post());
				/*
				清掉上次验证码和密码的输入
				 */
				$register_model->password = '';
				$register_model->repeat_password = '';
				$captcha -> code = '';
				return $this->renderPartial( 'register' , [ 'model' => $register_model , 'captcha' => $captcha ] );
			}

		}
		return $this->renderPartial('register' , [ 'model' => $register_model , 'captcha' => $captcha ]);
	}

}

?>
