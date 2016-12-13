<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use app\models\PersonalInfoModel;
use app\models\LinkModel;
use app\models\UserModel;
use app\models\CaptchaCode;
use app\models\PersonalInfo;
use app\models\User;
use app\models\LinkType;

class AdminController extends Controller{

	public $layout  = 'admin_base';

	public function actionIndex(){

		$view = YII::$app->view;
		$auth = Yii::$app->authManager;
		$view->params['user_info'] = Yii::$app->user->getIdentity();
		$view->params['personal_info'] = PersonalInfo::findIdentity($view->params['user_info']->id);
		$view->params['user_access'] = $auth->getRolesByUser($view->params['user_info']->id);
		return $this->render('index');

	}


	public function actionUserList(){

		$personal_info_form = new PersonalInfoModel;
		$user_info_form = new UserModel;
		$personal_info_form->scenario = 'updatePersonalInfo';
		$user_info_form->scenario = 'updateByAdmin';

		if ( Yii::$app->request->isPost && !Yii::$app->user->isGuest ){

			$personal_info_form->load(Yii::$app->request->post());
			$user_info_form->load(Yii::$app->request->post());

            if ( $personal_info_form->savePersonalInfo($personal_info_form->uid) || $user_info_form->saveUsername($personal_info_form->uid)){

                $this->redirect(['admin/user-list']);

            }else{

                $this->redirect(['admin/user-list']);

            }

		}

		$view = YII::$app->view;
        $auth = Yii::$app->authManager;
        $view->params['user_info'] = Yii::$app->user->getIdentity();
		$view->params['personal_info'] = PersonalInfo::findIdentity($view->params['user_info']->id);
        $view->params['user_access'] = $auth->getRolesByUser($view->params['user_info']->id);
		$dataProvider = new ActiveDataProvider([
		    'query' => User::find()->with('personalInfo'),
		    'pagination' => [
		        'pageSize' => 20,
		    ],
		]);
		return $this->render( 'user-list' , [ 'personal_info_form' => $personal_info_form , 'user_info_form' => $user_info_form , 'dataProvider' => $dataProvider ] );
	}


	public function actionUserAdd(){

		$user_info_form = new UserModel;
		$captcha = new CaptchaCode;
		$user_info_form->scenario = 'userAdd';

		$view = YII::$app->view;
		$auth = Yii::$app->authManager;
		$view->params['user_info'] = Yii::$app->user->getIdentity();
		$view->params['personal_info'] = PersonalInfo::findIdentity($view->params['user_info']->id);
		$view->params['user_access'] = $auth->getRolesByUser($view->params['user_info']->id);

		if ( Yii::$app->request->isPost && !Yii::$app->user->isGuest ){
			$user_info_form->load(Yii::$app->request->post());
			if( $user_info_form->register() ){
				return $this->redirect( ['admin/user-add'] );
			}else{
				return $this->render( 'user-add' , [ 'user_info_form' => $user_info_form , 'captcha' => $captcha ] );
			}
		}

		return $this->render( 'user-add' , [ 'user_info_form' => $user_info_form , 'captcha' => $captcha ] );
	}


	public function actionLinksType(){
		$link_form = new LinkModel;
		$link_form->scenario = 'addLink';
		if ( Yii::$app->request->isPost && !Yii::$app->user->isGuest ){
			$link_form->load(Yii::$app->request->post());
			$link_form->saveLink();
		}
		$view = YII::$app->view;
        $auth = Yii::$app->authManager;
        $view->params['user_info'] = Yii::$app->user->getIdentity();
		$view->params['personal_info'] = PersonalInfo::findIdentity($view->params['user_info']->id);
        $view->params['user_access'] = $auth->getRolesByUser($view->params['user_info']->id);
		$dataProvider = new ActiveDataProvider([
		    'query' => LinkType::find(),
		    'pagination' => [
		        'pageSize' => 20,
		    ],
		]);
		return $this->render( 'links-type' , [ 'link_form' => $link_form , 'dataProvider' => $dataProvider ] );
	}


	public function actionAjaxGetUserInfo(){
		if ( Yii::$app->request->isPost && !Yii::$app->user->isGuest ){
			$uid = Yii::$app->request->post()['uid'];
			$query = User::find()->select( [ 'id' , 'username' , 'email' ] )->where( [ 'id' => $uid ] )->with('personalInfo')->one();
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return [ 'UserInfoModel' => $query , 'personalinfo' => $query->personalInfo ,'id' => Yii::$app->request->post()];
		}
	}


	public function actionUserDel(){
		if( substr(Yii::$app->request->referrer,strrpos(Yii::$app->request->referrer,'/')+1) != 'user-list' ){
			return false;
		}
		if ( Yii::$app->request->isPost && !Yii::$app->user->isGuest ){

		}
	}


	public function actionLinkChange(){
		if ( Yii::$app->request->isPost && !Yii::$app->user->isGuest ){
			$link_form = new LinkModel;
			$link_form->scenario = 'changeLink';
			$link_form->load(Yii::$app->request->post());
			if ($link_form->changeLink($link_form->id)){
				return $this->redirect(['admin/links-type']);
			}else {
				return $this->redirect(['admin/links-type']);
			}
		}
	}

}

?>
