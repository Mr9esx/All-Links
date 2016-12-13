<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\City;
use app\models\UploadForm;
// use yii\helpers\ArrayHelper;
// use yii\filters\auth\QueryParamAuth;
// use yii\rest\ActiveController;

class ApiController extends Controller
{

    public function actionGetParentCity(){
        if (Yii::$app->request->isAjax && !Yii::$app->user->isGuest){
            $data = Yii::$app->request->post();
            $city = new City();
            $parent_city = $city::findAll( [ 'parent_id' => '0' ] );
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'parent_city' => $parent_city
            ];
       }else{
           return 'error';
       }
   }

   public function actionGetSonCity(){
       if (Yii::$app->request->isAjax && !Yii::$app->user->isGuest){
           $city = new City();
           $son_city = $city::findAll( [ 'parent_id' => Yii::$app->request->get('parent_id') ] );
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           return [
               'son_city' => $son_city
           ];
      }else{
          return 'error';
      }
  }

   // public function actionUploadUserLogo(){
   //     if (Yii::$app->request->isAjax && !Yii::$app->user->isGuest){
   //         $uploadmodel = new UploadForm;
   //         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
   //         $uploadmodel->file = UploadedFile::getInstance($uploadmodel, 'file');
   //         return "ok";
   //         if ($uploadmodel->file && $uploadmodel->validate()) {
   //             $uploadmodel->file->saveAs('uploads/' . $uploadmodel->file->baseName . '.' . $uploadmodel->file->extension);
   //             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
   //             return "ok";
   //         }else{
   //             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
   //             return "no";
   //         }
   //    }else{
   //        return 'error';
   //    }
   // }

}

?>
