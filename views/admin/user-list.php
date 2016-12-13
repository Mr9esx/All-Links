<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;

use app\models\City;
function br2nl($text) {
    return preg_replace('/<br\\s*?\/??>/i', '', $text);
}

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

AppAsset::register($this);
AppAsset::addScript($this,'/js/adminUserAction.js');
AppAsset::addScript($this,'/js/createFlatpcikr.js');
AppAsset::addScript($this,'/lib/flatpickr/dist/flatpickr.min.js');
AppAsset::addCss($this,'/lib/flatpickr/dist/flatpickr.min.css');
$this->title = 'All Links - 用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<h3 class="ui header">用户列表</h3>
<div class="ui divider"></div>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{items}{pager}<div style="clear:both"></div>',
    'columns' => [
        [
            'label' => 'ID',
            'attribute' => 'id',
            'value' => 'id',
            'options'=>[
                'width'=>'50px',
            ]
        ],
        [
            'label' => '头像',
            'format' => 'raw',
            'value' => function($m){
                return Html::img($m->personalInfo->user_logo,['class' => 'ui avatar image']
                );
            },
            'options' => [
                'width' => '60px',
            ]
        ],
        [
            'label' => '用户名',
            'attribute' => 'username',
            'value' => 'username',
            'options'=>[
                'width'=>'12%',
            ]
        ],
        [
            'label' => '昵称',
            'attribute' => 'personalInfo.nickname',
            'value' => 'personalInfo.nickname',
            'options'=>[
               'width'=>'12%',
            ]
        ],
        [
            'label' => '邮箱',
            'attribute' => 'email',
            'value' => 'email',
            'options'=>[
               'width'=>'15%',
            ]
        ],
        [
            'label' => '注册时间',
            'attribute' => 'register_at',
            'value' => 'register_at',
            'options'=>[
               'width'=>'18%',
            ]
        ],
        [
            'label' => '最近登陆',
            'attribute' => 'last_login_time',
            'value' => 'last_login_time',
            'options'=>[
               'width'=>'18%',
            ]
        ],
        [
        //动作列yii\grid\ActionColumn
        //用于显示一些动作按钮，如每一行的更新、删除操作。
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{update} {delete}',//只需要展示删除和更新
            'headerOptions' => ['width' => '15%'],
            'buttons' => [
                'update' => function($url, $personal_info_form, $key){
                    return Html::tag('a', '修改' , [ 'class' => 'mini ui button blue userChangeBtn' , 'value' => $key ]);
                    // return Html::a('<button class="mini ui button blue">修改</button>',
                    //     ['user-change-info', 'id' => $key]
                    // );
                },
                'delete' => function($url, $personal_info_form, $key){
                    return Html::tag('a', '删除' , [ 'class' => 'mini ui button red userDelBtn' , 'value' => $key ]);
                    // return Html::a('<button class="mini ui button red">删除</button>',
                    // [ 'value' => $key ]
                    //     ['user-del', 'id' => $key],
                    //     [
                    //         'data' => ['confirm' => '你确定要删除文章吗？',]
                    //     ]
                    // );
                },
            ],
        ],

        // 更多复杂列
    ],
    'pager'=>[
        //'options'=>['class'=>'hidden']//关闭分页
        'firstPageLabel'=>"首页",
        'prevPageLabel'=>'上一页',
        'nextPageLabel'=>'下一页',
        'lastPageLabel'=>'最后',
     ]
]);?>

<div class="ui userChange modal">
    <div class="header">
        修改资料
    </div>
    <div class="content">
        <?php $form = ActiveForm::begin([
            'id' => 'user-change-form',
            'fieldConfig' => [
                'template' => '{label}{input}<div class="error_tag">{error}</div>',
            ],
        ]); ?>
        <?= $form->field( $personal_info_form , 'uid' )->hiddenInput( [ 'id' => 'uid' ] )->label(false);?>
        <div class="ui form" style="margin-top:0;">
            <div class="two fields">
    			<div class="field">
                    <label>昵称</label>
                    <?= $form->field($personal_info_form, 'nickname')->textInput( [ 'id' => 'nickname' , 'value' => '' , 'autofocus' => true ] )->label(false); ?>
                </div>
                <div class="field">
    				<label>用户名</label>
                    <?= $form->field($user_info_form, 'username')->textInput( [ 'id' => 'username' , 'value' => '' , 'autofocus' => true] )->label(false); ?>
        		</div>
    		</div>
            <div class="field">
                <label>邮箱地址</label>
                <?= $form->field($user_info_form, 'email')->textInput( [ 'id' => 'email' , 'value' => '' , 'autofocus' => true] )->label(false); ?>
            </div>
    		<div class="two fields">
    			<div class="field">
    				<label>性别</label>
    				<?= $form->field( $personal_info_form , 'sex' )->dropDownList( [ '0' => '男性' , '1' => '女性' , '2' => '保密' ] , [ 'id' => 'sex' , 'prompt' => '请选择...'])->label(false); ?>
    			</div>
                <div class="field">
    				<label>出生日期</label>
    				<?= $form->field( $personal_info_form, 'date_of_birth' , ['labelOptions' => [ 'label' => '' ] ] )->textInput( [ 'id' => 'date_of_birth' , 'value' => '' , 'style' => 'height:40px;' ,'autofocus' => true ] ); ?>
    			</div>
    		</div>

    		<div class="field">
                <label>所在地</label>
            </div>
    		<div class="two fields">
    			<div class="field">
    				<?= Html::activeDropDownList($personal_info_form, 'parent_city' ,ArrayHelper::map(City::find()->where([ 'parent_id' => '0' ] )->all(), 'area_id', 'city_name'),[ 'id' => 'parent_city' ]) ?>
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
    				<?= $form->field($personal_info_form, 'relationship_status')->dropDownList(['0' => '未婚', '1' => '已婚', '2' => '保密'],[ 'id' => 'relationship_status' , 'prompt' => '请选择...'])->label(false); ?>
    			</div>
    			<div class="field">
    				<label>学历</label>
    				<?= $form->field($personal_info_form, 'education')->dropDownList(['0' => '小学', '1' => '初中', '2' => '中专', '3' => '高中', '4' => '大专', '5' => '本科', '6' => '本科以上', '7' => '保密'] , [ 'id' => 'education' , 'prompt' => '请选择...' ] )->label(false); ?>
    			</div>
    		</div>
    		<div class="field">
    			<label>个人心情</label>
    			<?= $form->field($personal_info_form, 'mood',['template'=>"{input}\n{error}"])->textarea([ 'id' => 'mood' , 'rows' => 8 , 'placeholder' => '可以输入50个字。' , 'value' => Html::encode(br2nl($this->params['personal_info']->mood))])->label(false) ?>
    		</div>
    	</div>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="actions">
        <div class="ui black deny button">
            取消
        </div>
        <div class="ui positive right labeled icon button">
            确认
            <i class="checkmark icon"></i>
        </div>
    </div>

</div>

<div class="ui basic delCheck modal">
	<div class="ui icon header"><i class="archive icon"></i> 确认删除 <span id="del_username"></span> ？ </div>
	<div class="actions" style="text-align:center;">
		<div class="ui red cancel inverted button"><i class="remove icon"></i> No </div>
		<div class="ui green ok inverted button"><i class="checkmark icon"></i> Yes </div>
	</div>
</div>
