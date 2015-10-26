<?php
namespace app\assets;

use yii;
use yii\web\AssetBundle;

/**
 * @author fuheng ieHTML5兼容资源
 * @since 1.0
 */
class kindEditor extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web/styles/default/lib/kindeditor-4.1.10';    
    public $js = [        
        'kindeditor-min.js',
        'lang/zh_CN.js',
    ];
}
