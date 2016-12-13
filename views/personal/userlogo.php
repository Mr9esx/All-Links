<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\City;
use app\assets\AppAsset;

$this->title = $this->params['user_info']->username.' - 个人头像';

// AppAsset::addScript($this,'/lib/Jcrop/js/jquery.Jcrop.min.js');
// AppAsset::addCss($this,'/lib/Jcrop/css/jquery.Jcrop.min.css');
AppAsset::addScript($this,'/lib/cropper/cropper.min.js');
AppAsset::addCss($this,'/lib/cropper/cropper.min.css');
AppAsset::addScript($this,'/js/cropUserLogo.js')

?>
<div class="twelve wide column">
    <?php $form = ActiveForm::begin( [ 'id' => 'user-logo-form' , 'options' => [ 'enctype' => 'multipart/form-data' ] ] ) ?>
    <div class="ui form segment" style="margin-top:0;">
        <h3 class="ui header">个人头像</h3>
        <div class="ui divider"></div>
        <div class="ui special cards" style="padding:20px 0 20px 0;">
            <div class="card" style="margin:0 auto;" >
                <div class="blurring dimmable image" id="dimmableBox">
                    <!-- <div class="ui dimmer">
                        <div class="content">
                            <div class="center">
                                <div class="ui inverted button" id="changeUserLogo">更换头像</div>
                            </div>
                        </div>
                    </div> -->
                    <img id="image" src="<?=Html::encode($this->params['personal_info']->user_logo)?>">
                </div>
                <div class="content">
                    <a class="header"><?=Html::encode($this->params['user_info']->username)?></a>
                    <div class="meta">
                        <span class="date"><?=Html::encode($this->params['personal_info']->nickname)?></span>
                    </div>
                </div>
                <div class="extra content">
                    <p><i class="time icon"></i><?=date('Y-m-d',strtotime($this->params['user_info']->register_at))?></p>
                </div>
            </div>
        </div>


        <?= $form->field( $model , 'lastPhoto' )->hiddenInput( [ 'id' => 'lastPhoto' ] )->label(false);?>
        <?= $form->field( $model , 'x' )->hiddenInput( [ 'id' => 'x' ] )->label(false);?>
        <?= $form->field( $model , 'y' )->hiddenInput( [ 'id' => 'y' ] )->label(false);?>
        <?= $form->field( $model , 'height' )->hiddenInput( [ 'id' => 'height' ] )->label(false);?>
        <?= $form->field( $model , 'width' )->hiddenInput( [ 'id' => 'width' ] )->label(false);?>

        <div class="ui three column centered grid" style="display:block;margin-top:0;" id="changeUserLogoBox">
            <div class="column">
                <button type="button" class="ui button" style="width:100%;" id="changeUserLogo">更换头像 </button>
            </div>
        </div>
        <div class="ui three column centered grid" style="display:none;margin-top:0;" id="userLogoFileBox">
            <div class="column" id="userLogoFile">
                <?= $form->field( $model , 'file' )->fileInput( [ 'id' => 'selectPhotoFile' , 'onchange' => 'uploadFile("'.Url::toRoute(['personal/upload-photo']).'")' ] )->label( false )?>
                <button class="ui button uploadDeny" type="button" style="margin-top:15px;width:100%;">取消 </button>
            </div>
        </div>
        <div class="ui three column centered grid" style="display:none;margin-top:0;" id="changeActionBox">
            <div class="column">
                <button class="ui button uploadDeny" type="button">取消 </button>
                <button class="ui button right floated" type="submit" id="">确认 </button>
            </div>
        </div>

    </div>
    <?php ActiveForm::end() ?>
</div>
