<?php

namespace sv\article;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'sv\article\controllers';    
    public $layout = "article-main";
    public $assetUrl = "@web";
    
    public function init()
    {
        parent::init();
        Yii::setAlias('@assetUrl', $this->assetUrl);
        // custom initialization code goes here
    }
}
