<?php

namespace sv\article\controllers;

use yii\web\Controller;
use sv\article\models\Posts;
// use sv\article\models\Post;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $posts = Posts::find()->all();
        return $this->render('index',[
            'posts' => $posts,
        ]);
    }
}
