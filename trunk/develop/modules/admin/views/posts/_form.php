<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sv\admin\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<?=sv\admin\PostWidget::Widget();?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>
    <!-- 标题     -->
    <?= $form->field($model, 'post_title')->input(['rows' => 6]) ?>
    <!-- 内容 -->
    <?= $form->field($model, 'post_content')->textarea(['rows' => 6]) ?>
    <!-- 摘要 -->
    <?= $form->field($model, 'post_excerpt')->textarea(['rows' => 6]) ?>
    <!-- 作者 -->
    <?= $form->field($model, 'post_author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_date')->textInput() ?>

    <?= $form->field($model, 'post_date_gmt')->textInput() ?>



    

    <?= $form->field($model, 'post_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ping_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_ping')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pinged')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_modified')->textInput() ?>

    <?= $form->field($model, 'post_modified_gmt')->textInput() ?>

    <?= $form->field($model, 'post_content_filtered')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_parent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'menu_order')->textInput() ?>

    <?= $form->field($model, 'post_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
