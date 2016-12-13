<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;
use yii\captcha\Captcha;

use app\models\City;
function br2nl($text) {
    return preg_replace('/<br\\s*?\/??>/i', '', $text);
}


AppAsset::register($this);
$this->title = 'All Links - 添加用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<h3 class="ui header">添加用户</h3>
<div class="ui divider"></div>
<?php $form = ActiveForm::begin([
    'id' => 'user-add-form',
    'fieldConfig' => [
        'template' => '{label}{input}<div class="error_tag">{error}</div>',
    ],
]); ?>
<div class="ui form" style="margin-top:0;">
    <div class="two fields">
        <div class="field">
            <label>用户名</label>
            <?= $form->field( $user_info_form, 'username')->textInput(['placeholder'=>'Username','autofocus' => true] )->label(false); ?>
        </div>
        <div class="field">
            <label>邮箱</label>
            <?= $form->field($user_info_form, 'email' )->textInput(['placeholder'=>'E-mail','autofocus' => true])->label(false); ?>
        </div>
    </div>
    <div class="two fields">
        <div class="field">
            <label>密码</label>
            <?= $form->field($user_info_form, 'password' )->passwordInput(['placeholder'=>'Password','autofocus' => true])->label(false); ?>
        </div>
        <div class="field">
            <label>再输入一次密码</label>
            <?= $form->field($user_info_form, 'repeat_password' )->passwordInput(['placeholder'=>' Repeat Password','autofocus' => true])->label(false); ?>
        </div>
    </div>

    <div class="field" style="margin-bottom:0px;">
        <label>验证码</label>
        <div class="ui grid">
        <?=Captcha::widget([
            'model' => $captcha,
            'attribute' => 'code',
            'captchaAction' => 'captcha/captcha',
            'template' => '<div class="fourteen wide column">{input}</div><div class="two wide column">{image}</div>',
            'options' => [
                'id' => 'input',
            ],
            'imageOptions' => [
                'alt' => '点击刷新',
            ],
        ]);?>
        </div>
    </div>
    <?=Html::error( $captcha , 'code' , ['class' => 'red'])?>

    <div class="ui divider"></div>
    <button type="submit" class="fluid ui button blue">添 加</button>
</div>
<?php ActiveForm::end(); ?>
