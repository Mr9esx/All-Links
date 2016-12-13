<?php


namespace app\assets;
use yii\web\AssetBundle;

class SemanticUIAsset extends AssetBundle
{
    public $sourcePath = '@bower/semantic-ui/dist';
    public $css = [
        'semantic.css',
    ];
    public $js = [
        'semantic.js',
    ];
}
