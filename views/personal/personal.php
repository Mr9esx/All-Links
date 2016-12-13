<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\City;
use app\assets\AppAsset;
AppAsset::addScript($this,'/js/createFlatpcikr.js');
AppAsset::addScript($this,'/js/saveModel.js');
AppAsset::addScript($this,'/lib/flatpickr/dist/flatpickr.min.js');
AppAsset::addCss($this,'/lib/flatpickr/dist/flatpickr.min.css');

$this->registerJs(
   '$(document).ready(function(){
	   $("#parent_city").change(function(){
		   $("#son_city").empty();
		   $.ajax({
			   url: "'.Url::toRoute(['api/get-son-city' , 'parent_id' => '']).'"+$(this).children("option:selected").val(),
			   type: "post",
			   success: function (data) {
				   for(var i =0;i<data.son_city.length;i++){
					   $("#son_city").append("<option value=\'"+data.son_city[i][\'area_id\']+"\'>"+data.son_city[i][\'city_name\']+"</option>");
				   }
			   }
		   });
	   });
   });'
);

function br2nl($text) {
    return preg_replace('/<br\\s*?\/??>/i', '', $text);
}


$this->title = $this->params['user_info']->username.' - 个人资料';

// AppAsset::addScript($this,'/lib/editor.md/editormd.min.js');
// AppAsset::addCss($this,'/lib/editor.md/css/editormd.css');.
// AppAsset::addScript($this,'/lib/wangEditor/js/wangEditor.min.js');
// AppAsset::addCss($this,'/lib/wangEditor/css/wangEditor.min.css');
?>
<?php //$form = ActiveForm::begin(["options" => ["enctype" => "multipart/form-data"]]); ?>

<div class="twelve wide column">
	<?php $form = ActiveForm::begin([
		'id' => 'user-info-form',
		'fieldConfig' => [
			'template' => '{label}{input}<div class="error_tag">{error}</div>',
		],
	]); ?>
	<div class="ui form segment" style="margin-top:0;">
        <h3 class="ui header">个人资料</h3>
        <div class="ui divider"></div>
		<div class="field">
			<label>昵称</label>
            <?= $form->field($personal_info_form, 'nickname')->textInput(['value'=>Html::encode($this->params['personal_info']->nickname),'autofocus' => true])->label(false); ?>
		</div>
		<div class="field">
			<label>用户名</label>
            <div class="ui action input">
                <input value="<?=Html::encode($this->params['user_info']->username)?>" readonly="readonly" type="text">
                <button class="ui icon button">
                    <i class="user icon"></i>
                </button>
            </div>
		</div>
        <div class="field">
            <label>邮箱地址</label>
            <div class="ui action input">
                <input value="<?=Html::encode($this->params['user_info']->email)?>" readonly="readonly" type="text">
                <button class="ui icon button">
                    <i class="mail outline icon"></i>
                </button>
            </div>
        </div>
		<div class="two fields">
			<div class="field">
				<label>性别</label>
				<?= $form->field($personal_info_form, 'sex')->dropDownList(['0' => '男性', '1' => '女性', '2' => '保密'],['prompt' => '请选择...'])->label(false); ?>
			</div>
            <div class="field">
				<label>出生日期</label>
				<?= $form->field($personal_info_form, 'date_of_birth' ,['labelOptions' => [ 'label' => '' ]])->textInput(['id' => 'date_of_birth', 'style' => 'height:40px;' ,'autofocus' => true]); ?>
			</div>
		</div>

		<div class="field">
            <label>所在地</label>
        </div>
		<div class="two fields">
			<div class="field">
				<?= Html::activeDropDownList($personal_info_form, 'parent_city' ,ArrayHelper::map(City::find()->where([ 'parent_id' => '0' ] )->all(), 'area_id', 'city_name'),['id' => 'parent_city']) ?>
			</div>
			<div class="field">
				<?php
					if (!$this->params['personal_info']->location){
						echo $form->field($personal_info_form, 'son_city')->dropDownList([],['id' => 'son_city'])->label(false);
					}else{
						echo Html::activeDropDownList($personal_info_form, 'son_city' ,ArrayHelper::map(City::find()->where([ 'parent_id' => $personal_info_form->parent_city ] )->all(), 'area_id', 'city_name'),['id' => 'son_city']);
					}
				?>
			</div>
		</div>
		<div class="two fields">
			<div class="field">
				<label>感情状态</label>
				<?= $form->field($personal_info_form, 'relationship_status')->dropDownList(['0' => '未婚', '1' => '已婚', '2' => '保密'],['prompt' => '请选择...'])->label(false); ?>
			</div>
			<div class="field">
				<label>学历</label>
				<?= $form->field($personal_info_form, 'education')->dropDownList(['0' => '小学', '1' => '初中', '2' => '中专', '3' => '高中', '4' => '大专', '5' => '本科', '6' => '本科以上', '7' => '保密'],['prompt' => '请选择...'])->label(false); ?>
			</div>
		</div>
		<div class="field">
			<label>个人心情</label>
			<?= $form->field($personal_info_form, 'mood',['template'=>"{input}\n{error}"])->textarea(['rows'=>10 , 'placeholder' => '可以输入50个字。' , 'value' => Html::encode(br2nl($this->params['personal_info']->mood))])->label(false) ?>
			<!-- <textarea id='description'></textarea> -->
			<!-- <div id="test-editormd">
				<textarea style="display:none;">[TOC]
				#### Disabled options

				- TeX (Based on KaTeX);
				- Emoji;
				- Task lists;
				- HTML tags decode;
				- Flowchart and Sequence Diagram;
				</textarea>
			</div> -->
		</div>
		<button type="button" class="ui submit blue button" id="savePersonalInfoBtn">保存</button>
	</div>
	<?php ActiveForm::end(); ?>
</div>
<div class="ui basic savePersonalInfoCheck modal">
	<div class="ui icon header"><i class="archive icon"></i> 确认保存？ </div>
	<div class="actions" style="text-align:center;">
		<div class="ui red cancel inverted button"><i class="remove icon"></i> No </div>
		<div class="ui green ok inverted button"><i class="checkmark icon"></i> Yes </div>
	</div>
</div>
