<?php
use yii\helpers\Html;
use yii\helpers\Url;
// use sw\admin\assets\AppFrameAsset;
// use app\assets\AppAsset;
use sv\admin\assets\AdminAsset;
// use sv\components\SvPost;
AdminAsset::register($this);


$_menu = [
    [  'label' => '用户' , 'url' => ['/admin/users'],  ],
    [  'label' => '文章' , 'url' => ['/admin/posts'],  ],
    [  'label' => 'RBAC' , 'url' => ['/rbac'],  ],
    [  'label' => '修改密码' , 'url' => ['/admin/change-my-password/update'],  ],
    // [  'label' => '学校' , 'url'=> ['school/index'],  ],
    // [  'label' => '门店' , 'url'=> ['store/index'], 'rule' => 'admin-store' ],
    // [  
    //     'label' => '文章' , 
    //     'items' => [
    //         [  'label' => '文章' , 'url'=> ['article/index'], 'rule' => 'admin-article'  ],    
    //         [  'label' => '文章类别' , 'url'=> ['article-class/index'], 'rule' => 'admin-article-class' ],
    //     ]

    // ], 
];


function menutree($tree){
   
    foreach ($tree as $kt => $branche) {

        $access = true;

        //权限判断
        // if(  isset($branche['rule'])  )
        //     if(  !Yii::$app->user->identity->check($branche['rule'])  )$access = false;

        if(  $access  ){
            echo '<li class="list-group-item">';
            if(  isset($branche['items'])  ){
                echo '<span>'.$branche['label'].'</span>';
                echo '<ul>';          
                menutree($branche['items']);
                echo '</ul>';
            }else{
                echo Html::a(
                            $branche['label']
                            ,$branche['url']
                            // ['target'=>"_blank"]
                            // ,['target'=>"contentContainer"]
                            );
            }
            echo '</li>';   
        }
     
    }
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->params['title']) ?> - 管理后台</title>
<!--     <link rel="shortcut icon" href="favicon.ico"/>
    <link rel="bookmark" href="favicon.ico"/> -->    
    <?php $this->head() ?>
    <style>
        html,body{width:100%;}
        body{margin:0px;padding: 0px;}
        .body{width:100%;}
        /*.container{width:100%;}*/
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<header>
    <?php if ( Yii::$app->user->isGuest ):?>
    <?=Html::a('<span class="glyphicon glyphicon-heart-empty"></span> 登录',['/site/login'])?>
    <?php else: ?>
    <?=Html::a('<span class="glyphicon glyphicon-off"></span> 退出 (' . Yii::$app->user->identity->display_name . ')  ',['/site/logout'],['data-method'=>'post'])?>        
    <?php endif; ?>
</header>

<div class="body container">
<div class="row">
    <div class="col-xs-5 col-md-2" id="main-nav">
        <ul class="list-group">                
            <?php  menutree($_menu);?>               
        </ul>        
    </div>
    <div class="col-xs-7 col-md-10">
        <?=$content?>    
    </div>
</div>
</div>


<footer>
    
</footer>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
