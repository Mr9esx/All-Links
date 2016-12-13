<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style type="text/css">
            .meta{
                font-size: 0.9em !important;
            }
        </style>
    </head>
    <body>

    <?php $this->beginBody() ?>
        <div class="main">
            <div class="ui menu fixed" style="z-index:999;">
                <div class="item">
                    <img class="ui avatar image" src="<?=$this->params['personal_info']->user_logo?>" style="margin-right:10px;">
                    <?=$this->params['user_info']->username?>
                    <a href="<?=Url::toRoute('logout/logout')?>" style="margin-left:10px;font-size:0.85em;color:#9f9f9f">[ 登出 ]</a>
                </div>
                <div class="right menu">
                    <a class="ui dropdown item" href="<?=Url::toRoute('app/index')?>">
                        <i class="home icon"></i>主页
                    </a>
                    <a class="ui dropdown item" href="<?=Url::toRoute('personal/index')?>">
                        <i class="user icon"></i>个人设置
                    </a>
                    <div class="item">
                        <div class="ui icon input">
                            <input type="text" placeholder="搜索...">
                            <i class="search icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui grid">
                <div class="three wide column ui vertical sticky menu fixed" style="height:100%;padding-top:55px;position:fixed;">
                    <div class="item">
                        <div class="header">All Links - 后台</div>
                        <div class="menu">
                            <a class="item" id="menu-index" href="<?=Url::toRoute('admin/index')?>">后台首页</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">用户管理</div>
                        <div class="menu">
                            <a class="item" id="menu-user-list" href="<?=Url::toRoute('admin/user-list')?>">用户列表</a>
                            <a class="item" id="menu-user-add" href="<?=Url::toRoute('admin/user-add')?>">添加用户</a>
                            <a class="item" href="<?=Url::toRoute('admin/user-password')?>">修改密码</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">权限管理</div>
                        <div class="menu">
                            <a class="item">权限列表</a>
                            <a class="item">添加权限</a>
                            <a class="item">添加角色</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">链接管理</div>
                        <div class="menu">
                            <a class="item" href="<?=Url::toRoute('admin/links-type')?>">链接列表</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="header">网站设置</div>
                        <div class="menu">
                            <a class="item">设置</a>
                        </div>
                    </div>
                    <div class="item footer" style="position:absolute;bottom:0px;width:95%;">
                        <div class="header">All Links</div>
                        <div class="menu">
                            <p class="item">Copyright © 2016 · All Rights Reserved · Mr9esx from <a href="http://www.nervgeek.com" target="_blank">NervGeek</a></p>
                        </div>
                    </div>

                </div>
                <div class="thirteen wide column right floated" style="margin-top:1.8em;margin-right:0.8em;">
                    <div class="ui segment">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    <?php $this->endBody() ?>
    </body>
    <script>
        $(document).ready(function(){
            <?php
                $route = Yii::$app->requestedRoute;
                if ($route=='admin/index'){
                    echo '$("#menu-index").addClass("active blue");';
                }else if ($route=='admin/user-list'){
                    echo '$("#menu-user-list").addClass("active blue");';
                }else if ($route=='admin/user-add'){
                    echo '$("#menu-user-add").addClass("active blue");';
                }
            ?>
        });
    </script>
</html>
<?php $this->endPage() ?>
