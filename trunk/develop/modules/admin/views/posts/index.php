<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel sv\admin\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'post_author',
            'post_date',
            'post_date_gmt',
            'post_content:ntext',
            // 'post_title:ntext',
            // 'post_excerpt:ntext',
            // 'post_status',
            // 'comment_status',
            // 'ping_status',
            // 'post_password',
            // 'post_name',
            // 'to_ping:ntext',
            // 'pinged:ntext',
            // 'post_modified',
            // 'post_modified_gmt',
            // 'post_content_filtered:ntext',
            // 'post_parent',
            // 'guid',
            // 'menu_order',
            // 'post_type',
            // 'comment_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
