<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\AppAsset;

$this->title = $this->params['user_info']->username.' - 个人简介';

// AppAsset::addScript($this,'/lib/editor.md/editormd.min.js');
// AppAsset::addCss($this,'/lib/editor.md/css/editormd.css');
AppAsset::addScript($this,'/lib/wangEditor/js/wangEditor.min.js');
AppAsset::addCss($this,'/lib/wangEditor/css/wangEditor.min.css');
AppAsset::addScript($this,'/js/createEditor.js');
AppAsset::addScript($this,'/js/saveModel.js');

?>
<div class="twelve wide column">
    <div class="ui form segment" style="margin-top:0;">
        <h3 class="ui header">个人简介</h3>
        <div class="ui divider"></div>
        <?php $form = ActiveForm::begin(['id' => 'user-description-form','options' => ['enctype' => 'multipart/form-data']]) ?>
        <div class="field">
            <label>简介</label>
            <textarea id='description' style="min-height:680px;" name="description"><?=Html::encode($this->params['personal_info']->description);?></textarea>
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
        <button type="button" class="ui submit blue button" id="save">保存</button>
        <?php ActiveForm::end() ?>
    </div>
</div>
<div class="ui basic saveCheck modal">
	<div class="ui icon header"><i class="archive icon"></i> 确认保存？ </div>
	<div class="actions" style="text-align:center;">
		<div class="ui red cancel inverted button"><i class="remove icon"></i> No </div>
		<div class="ui green ok inverted button"><i class="checkmark icon"></i> Yes </div>
	</div>
</div>
