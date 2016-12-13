<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
AppAsset::addScript($this,'/js/base.js');
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
            .mood{
                font-size: 0.95em !important;
                color: #6f6f6f !important;
            }
        </style>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <div class="main" style="padding-top:30px;">

                <div class="ui menu borderless fixed">
                    <div class="ui container">
                        <a class="ui item" href="<?=Url::toRoute('app/index')?>">
                            主页
                        </a>
                        <?php
                            foreach ($this->params['user_access'] as $key => $value) {
                                if ($key === 'Admin'){
                                    echo '<a class="ui item" target="_blank" href="'.Url::toRoute('admin/index').'">
                                        管理后台
                                    </a>';break;
                                }
                            }
                        ?>
                        <div class="right menu">
                            <div class="item">
                                <div class="ui icon input">
                                    <input type="text" placeholder="搜索...">
                                    <i class="search link icon"></i>
                                </div>
                            </div>
                            <div class="ui dropdown user_dropdown item" style="padding: 0.4rem 1rem;">
                                <img class="ui avatar image" style="width:2.3em;height:2.3em;margin-right:0px;" src="<?=$this->params['personal_info']->user_logo?>" style="margin-right:10px;">
                                <div class="menu">
                                    <a class="item" target="_blank" href="<?=Url::toRoute('personal/index')?>">个人设置</a>
                                    <a class="item" target="_blank" href="<?=Url::toRoute('personal/manage-links')?>">管理链接</a>
                                    <div class="ui divider"></div>
                                    <a class="item" target="_blank" href="<?=Url::toRoute('logout/logout')?>">登出</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="ui stackable grid container">
                <div class="four wide column">
                    <div class="ui card" style="width:100%;">
                        <div class="content">
                            <div class="image">
                                <img style="width:60px;float:left;border-radius:30px;" src="<?=$this->params['personal_info']->user_logo?>">
                                <div style="margin-left:70px;padding-top:2px;">
                                    <div class="header"><?=Html::encode($this->params['user_info']->username)?></div>
                                    <div class="meta"><?=Html::encode($this->params['personal_info']->nickname)?></div>
                                    <div class="meta">
                                      普通用户
                                    </div>
                                    <!-- <div class="meta">注册时间 : <?=date("Y-m-d",strtotime($this->params['user_info']->register_at))?></div> -->
                                </div>
                            </div>
                            <div class="mood" style="padding-top:10px;clear:both;">
                                <!-- <?=yii\helpers\Markdown::process($this->params['personal_info']->mood)?> -->
                                <?=Html::encode($this->params['personal_info']->mood)?>
                            </div>
                        </div>
                        <div class="extra content">
                            <div class="ui grid">
                                <div class="eight wide column">
                                    <a href="<?=Url::toRoute(['app/user','uid'=>$this->params['user_info']->id])?>"><i class="home icon"></i>
                                        主页
                                    </a>
                                </div>
                                <div class="eight wide column">
                                    <a href="<?=Url::toRoute('logout/logout')?>"><i class="sign out icon"></i>
                                        登出
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui vertical menu">
                        <div class="item">
                            <div class="ui transparent icon input">
                                <input type="text" placeholder="搜索用户...">
                                <i class="search icon"></i>
                            </div>
                        </div>
                        <a class="item" id="menu-index" href="<?=Url::toRoute('personal/index')?>">
                            <i class="user icon"></i> 个人资料
                        </a>
                        <a class="item" id="menu-user-add" href="<?=Url::toRoute('personal/user-description')?>">
                            <i class="info circle icon"></i> 个人简介
                        </a>
                        <a class="item" id="menu-user-list" href="<?=Url::toRoute('personal/upload-photo')?>">
                            <i class="grid layout icon"></i> 个人头像
                        </a>
                        <a class="item" id="menu-user-add" href="<?=Url::toRoute('personal/manage-links')?>">
                            <i class="mail icon"></i> 管理链接
                        </a>
                    </div>
                </div>
                <?= $content ?>
            </div>
        </div>
    <?php $this->endBody() ?>
    </body>
    <script type="text/javascript">


    </script>
    <script>
        $(document).ready(function(){


            <?php
                $route = Yii::$app->requestedRoute;
                if ($route=='personal/index'){
                    echo '$("#menu-index").addClass("active blue");';
                }else if ($route=='admin/user-list'){
                    echo '$("#menu-user-list").addClass("active blue");';
                }else if ($route=='admin/user-add'){
                    echo '$("#menu-user-add").addClass("active blue");';
                }
            ?>


        });


    </script>

    <!-- <script>
        var editor = new wangEditor('description');
        editor.create();

        var testEditor;

        $(function() {
            testEditor = editormd("test-editormd", {
                width   : "100%",
                height  : 300,
                syncScrolling : "single",
                path    : "/lib/editor.md/lib/",
                watch : false,
                toolbarIcons : function() {
                    return ["undo", "redo", "|", "bold" , "italic" , "ucwords" , "uppercase" , "lowercase" , "hr" , "|" , "list-ul" , "list-ol" , "|" , "link" , "reference-link", "image", "||", "watch", "fullscreen", "preview"]
                },
            });
        });
    </script> -->
</html>
<?php $this->endPage() ?>
