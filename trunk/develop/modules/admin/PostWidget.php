<?php
namespace sv\admin;

// use yii\base\View;
use yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * 文章组件
 */
class PostWidget extends Widget
{

    public function init($id=null)
    {
        if(  is_null($id)  )return false;
        parent::init();
    }

    public function run()
    {

        $view = $this->getview();
        $view->registerJsFile('@assetUrl/js/sv-admin-post.js');
        $js = '
            sv_admin_post.int();
        ';
        $view->registerJs($js,$view::POS_READY);
        // $view->registerJs($js);
        
        // PostAsset::register($view);
        // sv-admin-post.js
        // return $assetUrl;
        // echo 'sssssss'
        // return Html::encode($this->message);
        
    }
}
