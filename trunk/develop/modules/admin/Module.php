<?php

namespace sv\admin;
use yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'sv\admin\controllers';
    public $layout = "main";
    public $assetUrl = "@web";

    public function init()
    {
        parent::init();
        //设置资源目录别名
        Yii::setAlias('@assetUrl', $this->assetUrl);
    }
}
