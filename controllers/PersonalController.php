<?php

namespace app\controllers;

use Yii;

use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

use app\models\PersonalInfoModel;
use app\models\UserModel;
use app\models\PersonalInfo;
use app\models\UploadForm;
use app\models\Links;

class PersonalController extends Controller{

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

    /**
     *
     */
    public function actionIndex(){

        $uid = Yii::$app->user->getId();

        $personal_info_form = new PersonalInfoModel;
        $personal_info_form->scenario = 'updatePersonalInfo';

        if (Yii::$app->request->isPost){

            $personal_info_form->load(Yii::$app->request->post());

            if( $personal_info_form->savePersonalInfo($uid) ){
                $this->redirect(['personal/index']);
            }
            else{
                $this->redirect(['personal/index']);
            }

        }else{

            $view = YII::$app->view;
            $auth = Yii::$app->authManager;
            $view->params['user_info'] = Yii::$app->user->getIdentity();
            $view->params['personal_info'] = PersonalInfo::findIdentity($uid);
            $view->params['user_access'] = $auth->getRolesByUser($uid);

            /*
                判断是否存在地址，如果存在选择默认值，不存在则交由前端 ajax 获取。
            */
            if (!empty($view->params['personal_info']->location)){
                $personal_info_form->parent_city = substr($view->params['personal_info']->location,0,strpos($view->params['personal_info']->location,':'));
                $personal_info_form->son_city = substr($view->params['personal_info']->location,strpos($view->params['personal_info']->location,':')+1);
            }else{
                $view->params['personal_info']->location = false;
            }

            $personal_info_form->uid = $uid;
            $personal_info_form->mood = $view->params['personal_info']->mood;
            $personal_info_form->sex = $view->params['personal_info']->sex;
            $personal_info_form->date_of_birth = $view->params['personal_info']->date_of_birth;
            $personal_info_form->relationship_status = $view->params['personal_info']->relationship_status;
            $personal_info_form->education = $view->params['personal_info']->education;

            return $this->render( 'personal',[ 'personal_info_form' => $personal_info_form ] );
        }

    }

    /**
     *
     */
    public function actionUploadPhoto(){

        $uid = Yii::$app->user->getId();

        $personal_form = new PersonalInfoModel;
        $personal_form->scenario = 'updateUserLogo';

        if (Yii::$app->request->isPost) {

            if(empty(Yii::$app->request->post()['PersonalInfoModel']['lastPhoto'])){

                $personal_form->file = UploadedFile::getInstance($personal_form, 'file');
                $save_dir = 'uploads/' . $uid .'/tmp/';
                $this->checkDir($save_dir);

                if ($personal_form->file && $personal_form->validate()) {

                    $url = $save_dir . rand(1,999) . '-' . time() . '.' . $personal_form->file->extension;
                    $personal_form->file->saveAs($url);

                }

                return '/'.$url;

            }else{

                $post = Yii::$app->request->post();

                $avatar_dir = 'uploads/' . $uid .'/avatar/';
                $this->checkDir($avatar_dir);

                $file = Yii::getAlias('@app/web/'.Yii::$app->request->post()['PersonalInfoModel']['lastPhoto']);

                $image=Yii::$app->image->load($file);

                $path = $avatar_dir . rand(1,999) . '-' . time() . '.png';

                $avatar = $image->crop(
                    $post['PersonalInfoModel']['width'],
                    $post['PersonalInfoModel']['height'],
                    $post['PersonalInfoModel']['x'],
                    $post['PersonalInfoModel']['y'])->resize(280,280)->save($path);

                $personal_form->saveUserLogo('/'.$path);
                $this->redirect(['personal/upload-photo']);

            }

        }

        $view = YII::$app->view;
        $auth = Yii::$app->authManager;
        $view->params['user_info'] = Yii::$app->user->getIdentity();
        $view->params['personal_info'] = PersonalInfo::findIdentity($uid);
        $view->params['user_access'] = $auth->getRolesByUser($uid);

        return $this->render( 'userlogo' , [ 'model' => $personal_form ] );

    }

    /**
     *
     */
    public function actionManageLinks(){
        $uid = Yii::$app->user->getId();
        $view = YII::$app->view;
        $auth = Yii::$app->authManager;
        $view->params['user_info'] = Yii::$app->user->getIdentity();
        $view->params['personal_info'] = PersonalInfo::findIdentity($uid);
        $view->params['user_access'] = $auth->getRolesByUser($uid);
        $dataProvider = new ActiveDataProvider([
		    'query' => Links::find()->where( [ 'id' => $uid ] )->with('linkType'),
		    'pagination' => [
		        'pageSize' => 20,
		    ],
		]);
        return $this->render( 'managelinks' , [ 'dataProvider' => $dataProvider ] );
    }

    /**
     *
     */
    public function actionUserDescription(){

        $uid = Yii::$app->user->getId();
        $personal_info_form = new PersonalInfoModel;
        $personal_info_form->scenario = 'updateDescription';

        if (Yii::$app->request->isPost){

            $personal_info_form->load([ 'PersonalInfoModel' => Yii::$app->request->post() ]);

            if ($personal_info_form->saveDescription($uid)){

                $this->redirect(['personal/user-description']);

            }

        }

        $view = YII::$app->view;
        $auth = Yii::$app->authManager;
        $view->params[ 'user_info' ] = Yii::$app->user->getIdentity();
        $view->params[ 'personal_info' ] = PersonalInfo::findIdentity($uid);
        $view->params[ 'user_access' ] = $auth->getRolesByUser($uid);
        return $this->render( 'userdescription' , [ 'model' => $personal_info_form ] );

    }

    /**
     *
     */
    private function checkDir($save_dir){

        if(!is_dir($save_dir)){

            if(!mkdir($save_dir, 0777, true)){

                die('创建目录失败!');

            }

        }
    }

    // protected function findPersonalModel($id)
    // {
    //     if (($model = PersonalInfo::findOne($id)) !== null) {
    //         return $model;
    //     } else {
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }
    // }
    //
    // protected function findUserModel($id)
    // {
    //     if (($model = User::findOne($id)) !== null) {
    //         return $model;
    //     } else {
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }
    // }

}

?>
