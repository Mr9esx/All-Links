<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$UserInfoModel = Yii::$app->user->getIdentity();
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
    </head>
    <body>
    <?php $this->beginBody() ?>
        <div class="ui menu top_nav">
            <a class="active item">
                <i class="home icon"></i> 主页
            </a>
            <a class="item">
                <i class="mail icon"></i> 信息
            </a>


            <div class="right menu">
                <div class="item">
                    <div class="ui transparent icon input">
                        <input type="text" placeholder="搜索...">
                            <i class="search link icon"></i>
                    </div>
                </div>
                <div class="ui dropdown item menu-show-user">
                    <img src="/images/default-user.png" style="width:28px;margin-right: 10px;"/>
                    <?=$UserInfoModel->nickname?><i class="icon dropdown"></i>
                    <div class="menu">
                        <a class="item" href="<?=Url::toRoute(['app/user','uid'=>$UserInfoModel->id]);?>"><i class="user icon"></i> 个人中心</a>
                        <?php
                        if (Yii::$app->user->can('/app/admin')) {
                            $url = Url::toRoute('admin/index');
                            echo <<<EOD
                        <a class="item" href="$url">
                            <i class="mail icon"></i> 后台管理
                        </a>
EOD;


                        }
                        ?>
                        <a class="item"><i class="archive icon"></i> 管理连接</a>
                        <a class="item" href="<?=Url::toRoute('logout/logout')?>"><i class="sign out icon"></i> 登出</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main container">
            
            <?= $content ?>
        </div>
    <?php $this->endBody() ?>
    </body>
    <script>
        $('.menu-show-user')
            .dropdown({
                //transition: 'drop'
            })
        ;
    </script>
</html>
<?php $this->endPage() ?>
