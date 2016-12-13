<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

use app\models\City;
use app\assets\AppAsset;

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

	<div class="ui form segment" style="margin-top:0;">

        <h3 class="ui header">链接管理</h3>
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
                    'label' => 'icon',
                    'attribute' => 'linkType.icon',
                    'value' => 'linkType.icon',
                    'options'=>[
                        'width'=>'20%',
                    ]
                ],
                [
                    'label' => 'link',
                    'attribute' => 'link',
                    'value' => 'link',
                    'options'=>[
                        'width'=>'30%',
                    ]
                ],
                [
                    'label' => 'description',
                    'attribute' => 'description',
                    'value' => 'description',
                    'options'=>[
                        'width'=>'30%',
                    ]
                ],
                [
                //动作列yii\grid\ActionColumn
                //用于显示一些动作按钮，如每一行的更新、删除操作。
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '操作',
                    'template' => '{update} {delete}',//只需要展示删除和更新
                    'headerOptions' => ['width' => '20%'],
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

	</div>

</div>
<div class="ui basic saveLinkCheck modal">
	<div class="ui icon header"><i class="archive icon"></i> 确认保存？ </div>
	<div class="actions" style="text-align:center;">
		<div class="ui red cancel inverted button"><i class="remove icon"></i> No </div>
		<div class="ui green ok inverted button"><i class="checkmark icon"></i> Yes </div>
	</div>
</div>
