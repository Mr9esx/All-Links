<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class RbacController extends Controller
{

    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['init2'],
                        // 自定义一个规则，返回true表示满足该规则，可以访问，false表示不满足规则，也就不可以访问actions里面的操作啦
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('/app/admin');
                        },
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }*/

    public function actionInit ()
    {
        $auth = Yii::$app->authManager;
        // 添加 "/blog/index" 权限
        $blogIndex = $auth->createPermission('app/index');
        $blogIndex->description = '博客列表';
        $auth->add($blogIndex);
        // 创建一个角色blogManage，并为该角色分配"/blog/index"权限
        $blogManage = $auth->createRole('Admin');
        $auth->add($blogManage);
        $auth->addChild($blogManage, $blogIndex);
        // 为用户 test1（该用户的uid=1） 分配角色 "博客管理" 权限
        $auth->assign($blogManage, 1); // 1是test1用户的uid
    }

    public function actionCreate(){
        /*$auth = Yii::$app->authManager;
        // 添加 "/blog/index" 权限
        $blogIndex = $auth->getPermission('/app/index');
        // 创建一个角色blogManage，并为该角色分配"/blog/index"权限
        $blogManage = $auth->createRole('User');
        $auth->add($blogManage);
        $auth->addChild($blogManage, $blogIndex);
        // 为用户 test1（该用户的uid=1） 分配角色 "博客管理" 权限
        $auth->assign($blogManage, 1); // 1是test1用户的uid*/
    }

	public function actionInit2 ()
    {
        $auth = Yii::$app->authManager;

        // 添加权限
        $blogView = $auth->createPermission('app/error');
        $auth->add($blogView);


        // 分配给我们已经添加过的"博客管理"权限
        $blogManage = $auth->getRole('Admin');
        $auth->addChild($blogManage, $blogView);
    }

    public function actionInit3 ()
    {
        $auth = Yii::$app->authManager;

        // 添加权限
        $blogView = $auth->createPermission('app/admin');
        $auth->add($blogView);


        // 分配给我们已经添加过的"博客管理"权限
        $blogManage = $auth->getRole('Admin');
        $auth->addChild($blogManage, $blogView);
    }

}

?>