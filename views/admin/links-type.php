<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

AppAsset::addScript($this,'/js/adminLinkAction.js');

echo GridView::widget([
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
            'label' => '链接名称',
            'attribute' => 'link_type',
            'value' => 'link_type',
            'options'=>[
                'width'=>'20%',
            ]
        ],
        [
            'label' => '链接图标',
            'attribute' => 'icon',
            'format' => 'raw',
            'value' => function($m){
                return Html::tag('i','',
                            ['class' => $m->icon.' icon',
                            'width' => 30]
                );
            }
        ],
        [
            'label' => '链接简介',
            'attribute' => 'description',
            'value' => 'description',
            'options'=>[
                'width'=>'20%',
            ]
        ],
        [
            'label' => '创建时间',
            'attribute' => 'created_at',
            'value' => 'created_at',
            'options'=>[
                'width'=>'20%',
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
                    return Html::tag('a', '修改' , [ 'class' => 'mini ui button blue linkChangeBtn' , 'value' => $key ]);
                    // return Html::a('<button class="mini ui button blue">修改</button>',
                    //     ['user-change-info', 'id' => $key]
                    // );
                },
                'delete' => function($url, $personal_info_form, $key){
                    return Html::tag('a', '删除' , [ 'class' => 'mini ui button red linkDelBtn' , 'value' => $key ]);
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
    ],
]);
?>

<?php $form = ActiveForm::begin([
    'id' => 'link-add-form',
    'fieldConfig' => [
        'template' => '{label}{input}<div class="error_tag">{error}</div>',
    ],
]); ?>
<div class="ui form" style="margin-top:15px;">
    <div class="ui grid">
        <div class="four wide column">
            <div class="field">
                <label>链接名称</label>
                <?= $form->field($link_form, 'link_type')->textInput( [ 'value' => '' , 'autofocus' => true ] )->label(false); ?>
            </div>
        </div>
        <div class="four wide column">
            <div class="field">
                <label>图标 [<a href="http://www.semantic-ui.cn/elements/icon.html" target="_blank">图标列表</a>]</label>
                <?= $form->field($link_form, 'icon')->textInput( [ 'value' => '' , 'autofocus' => true] )->label(false); ?>
            </div>
        </div>
        <div class="four wide column">
            <div class="field">
                <label>简介</label>
                <?= $form->field($link_form, 'description')->textInput( [ 'value' => '' , 'autofocus' => true] )->label(false); ?>
            </div>
        </div>
        <div class="four wide column" style="padding-top:38px;">
            <button class="ui button blue" type="submit" style="width:100%;">添加</button>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>



<div class="ui linkChange modal">
    <div class="header">
        修改链接
    </div>
    <div class="content">
        <div class="ui form" style="margin-top:0;">
            <div class="three fields">
                <?php $form = ActiveForm::begin([
                                    'action' => ['admin/link-change'] ,'method'=>'post',
                                    'id' => 'link-change-form',
                                    'options'=>['style' => 'width:100%'],
                                    'fieldConfig' => [
                                        'template' => '{label}{input}<div class="error_tag">{error}</div>',
                                    ],
                                ]); ?>
                <?= $form->field( $link_form , 'id' )->hiddenInput( [ 'id' => 'id' ] )->label(false);?>
    			<div class="field">
                    <label>链接名称</label>
                    <?= $form->field( $link_form , 'link_type' )->textInput( [ 'id' => 'link_type' , 'value' => '' , 'style' => 'height:40px;' ,'autofocus' => true ] )->label(false); ?>
                </div>
    			<div class="field">
                    <label>图标 [<a href="http://www.semantic-ui.cn/elements/icon.html" target="_blank">图标列表</a>]</label>
                    <?= $form->field( $link_form , 'icon' )->textInput( [ 'id' => 'icon' , 'value' => '' , 'style' => 'height:40px;' ,'autofocus' => true ] )->label(false); ?>
    			</div>
                <div class="field">
                    <label>简介</label>
                    <?= $form->field( $link_form , 'description' )->textInput( [ 'id' => 'description' , 'value' => '' , 'style' => 'height:40px;' ,'autofocus' => true ] )->label(false); ?>
    			</div>
                <?php ActiveForm::end(); ?>
    		</div>
    	</div>
    </div>
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
