<?php

namespace sv\admin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $baseUrl = '@assetUrl';
    //需要引入的JS
    public $js = [
        'lib/responsive-nav/responsive-nav.min.js',
       
    ];
    //需要引入的CSS
    public $css = [
        // 'css/buttons.css',
        'lib/responsive-nav/responsive-nav.css',
    ];

    //资源依赖项
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];



}
