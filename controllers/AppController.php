<?php

/*
必须要有命名空间
 */
namespace app\controllers;

use Yii;
//vender/yiisoft/yii2/web/Controller.php
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\LoginForm;

class AppController extends Controller{

    public $layout  = 'base';

	/*public function behaviors()
    {
        return [
            //附加行为
            // 'myBehavior' => \backend\components\MyBehavior::className(),
            'as access' => [
                'class' => 'app\components\AccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['POST'],
                ],
            ],
        ];
    }*/

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

	public function actionIndex(){
		//如果未登陆指向登陆页面
        // var_dump(Yii::$app->user->isGuest);
        // var_dump(Yii::$app->session);
        // var_dump(Yii::$app->request->cookies);
        // var_dump(Yii::$app->user);
        // exit();
		if (Yii::$app->user->isGuest) {
            return $this->redirect(['register/register']);
        }else{
            return $this->redirect(['personal/index']);
           /* $view = YII::$app->view;
            $auth = Yii::$app->authManager;
            $view->params['UserInfoModel'] = Yii::$app->user->getIdentity();
            $view->params['user_access'] = $auth->getRolesByUser($view->params['UserInfoModel']->id);
            return $this->render('index');*/
        	/*if (!Yii::$app->user->can('/app/index')) {
		        echo "管理员.";

		    }else{
		    	echo "普通用户.";
		    }*/
		    //$model = new LoginForm();
            //return $this->render('index',[ 'model' => $model ]);
		    //echo "ok<br />";
			//echo "<a href=".Url::toRoute('logout/logout').">Logout</a>";
        	//var_dump(Yii::$app->user);
        	//echo "<a href=".Url::toRoute('logout/logout').">Logout</a>";
        }
	}

	public function actionUser(){
	    $uid = Yii::$app->request->get('uid');
        if ($uid){
            echo "ok";
            exit();
        }else{
            return $this->redirect(['app/index']);
        }
		//return $this->redirect(['register/register']);
	}

}

?>
