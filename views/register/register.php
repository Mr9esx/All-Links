    <?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
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
    </head>
    <body>
    <?php $this->beginBody() ?>
        <div class="main container">
            <div class="ui three column centered grid">
				<div class="column register_form">
					<div class="ui error form segment ">
						<?php $form = ActiveForm::begin([
					        'id' => 'register-form',
					        'fieldConfig' => [
					            'template' => '{label}{input}<div class="error_tag">{error}</div>',
					        ],
					    ]); ?>
						<h1 style="text-align:center;margin-bottom:30px;" class="ui header">注册</h1>
						<div class="ui horizontal divider">
							                     <i class="plus icon"></i>
						</div>
						<div class="field">
							<?= $form->field($model, 'username' ,['labelOptions' => ['label' => '用户名']])->textInput(['placeholder'=>'Username','autofocus' => true]); ?>
							<?=Html::error( $model , 'username' , [ 'class' => 'red' ] )?>
						</div>
						<div class="field" style="margin-top:1.5em;">
							<?= $form->field($model, 'password' ,['labelOptions' => ['label' => '密码']])->passwordInput(['placeholder'=>'Password','autofocus' => true]); ?>
						</div>
						<div class="field" style="margin-top:1.5em;">
							<?= $form->field($model, 'repeat_password' ,['labelOptions' => ['label' => '再输入一次密码']])->passwordInput(['placeholder'=>' Repeat Password','autofocus' => true]); ?>
						</div>
						<div class="field" style="margin-top:1.5em;">
						<?= $form->field($model, 'email' ,['labelOptions' => ['label' => '邮箱']])->textInput(['placeholder'=>'E-mail','autofocus' => true]); ?>
						</div>
						<div class="field" style="margin-top:1.5em;margin-bottom:0px;">
							<label>验证码</label>
							<div class="ui grid">
							<?=Captcha::widget([
								'model' => $captcha,
								'attribute' => 'code',
								'captchaAction' => 'captcha/captcha',
								'template' => '<div class="ten wide column">{input}</div><div class="four wide column">{image}</div>',
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


						<div class="inline field" style="margin-top:1.5em;">
							<!-- <div class="ui checkbox agree">
								<input type="checkbox" name="agree">
								<label>同意条款协议</label>
							</div> -->
                            <style>
                            .field-usermodel-agree{
                                float:left !important;
                            }
                            </style>
                            <?= $form->field($model, 'agree' )->checkbox(['label' => '同意条款协议']); ?>
							<label style="float:right;"><a href="<?=Url::to(['login/login']);?>">已有账号？登陆<i class="arrow circle right icon"></i></a></label>

						</div>



						<div class="ui divider" style="clear:both;margin-top:55px;;"></div>
						<button type="submit" class="fluid ui button blue">注 册</button>

						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
        </div>
    <?php $this->endBody() ?>
    </body>
    <script type="text/javascript">
		$(document).ready(function(){
			$('.dropdown').dropdown({
		    	transition: 'drop'
			});
			//$('#UserInfoModel-agree').parents().checkbox('attach events', '.uncheck.button', 'uncheck');
		});
	</script>
</html>
<?php $this->endPage() ?>
