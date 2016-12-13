<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

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
				<div class="column login_form">
					<div class="ui form segment ">
						<?php $form = ActiveForm::begin([
					        'id' => 'login-form',
					        'fieldConfig' => [
					            'template' => '{label}{input}<div class="error_tag">{error}</div>',
					        ],
					    ]); ?>
						<h1 style="text-align:center;margin-bottom:30px;" class="ui header">登陆</h1>
						<div class="ui horizontal divider">
							<i class="user icon"></i>
						</div>
						<div class="field">
							<?= $form->field($model, 'username' ,['labelOptions' => ['label' => '用户名']])->textInput(['placeholder'=>'Username','autofocus' => true]); ?>
						</div>
						<div class="field" style="margin-top:1.5em;">
							<?= $form->field($model, 'password' ,['labelOptions' => ['label' => '密码']])->passwordInput(['placeholder'=>'Password','autofocus' => true]); ?>
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
                            <style>
                            .field-loginform-rememberme{
                                float:left !important;
                            }
                            </style>
                            <?= $form->field($model, 'rememberMe')->checkbox(['label'=>'记住我']) ?>
							<!-- <div class="ui toggle checkbox test">
								<input type="checkbox" name="remember_me">
								<label>记住我</label>
							</div> -->
							<label style="float:right;"><a href="<?=Url::to(['register/register']);?>">现在注册<i class="arrow circle right icon"></i></a></label>
							<label style="float:right;padding-right:10px !important;"><a href="<?=Url::to(['register/register']);?>">忘记密码<i class="help circle icon"></i></a></label>
						</div>

						<div class="ui divider" style="clear:both;margin-top:55px;"></div>
						<button type="submit" class="fluid ui button blue">登 陆</button>
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
		    // 你可以使用任何过渡
		    	transition: 'drop'
			});
			$('.test.checkbox').checkbox('attach events', '.uncheck.button', 'uncheck');
		});
	</script>
</html>
<?php $this->endPage() ?>
