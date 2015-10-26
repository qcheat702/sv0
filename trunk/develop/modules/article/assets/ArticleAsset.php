<?php

namespace sv\article\assets;

use yii\web\AssetBundle;

class ArticleAsset extends AssetBundle
{
    public $baseUrl = '@assetUrl';
    //需要引入的JS
    public $js = [
        // 'lib/responsive-nav/responsive-nav.min.js',
       
    ];
    //需要引入的CSS
    public $css = [
        'css/site.css',
        // 'lib/responsive-nav/responsive-nav.css',
    ];

    //资源依赖项
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];



}
