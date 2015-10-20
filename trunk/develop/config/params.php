<?php

$config =  [
    'adminEmail'      => 'admin@example.com',
    'siteName'        => '码风窝',//网站名称
    'title'           => '码风窝',//网站标题（网站title前缀）
    'template'        => 'default',//当前模板
    
    'baseUrl'         => '@web/styles',//静态资源基础目录
    'defaultTemplate' => 'default',//默认模板（放置可重用资源极或者系统资源，请勿更改！）

];

//默认静态资源路径
$config['defaultAssetUrl'] = $config['baseUrl'].'/'.$config['defaultTemplate'];
//当前静态资源路径
$config['assetUrl']        = $config['baseUrl'].'/'.$config['template'];

return $config;