<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use sv\admin\assets\kindEditor;

use sv\admin\models\users;

kindEditor::register($this);
$this->registerJs('ready();');
$authors = users::find()->asArray()->all();
// var_dump($model->metas);

// var_dump($model->getMetas("article_category"));
// var_dump($model->article_category);
$model->setMeta('article_category3','xxx');


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
    <?= $form->field($model, 'post_author')->dropdownList(ArrayHelper::map($authors, 'ID', 'display_name')) ?>



    <?= $form->field($model, 'post_status')->dropdownList([
        'publish'=>'已发表',
        'draft'=>'草稿',
        'private'=>'私人'
    ]) ?>
   
    <?= $form->field($model, 'comment_status')->dropdownList([
        'open'=>'允许评论',
        'closed'=>'不允许评论',
        'registered_only'=>'只有注册用户可以评论'
    ]) ?>
    <!-- ping状态 open指打开pingback功能，closed为关闭 -->
    <?= $form->field($model, 'ping_status')->dropdownList([
        'open'=>'允许ping',
        'closed'=>'关闭ping'
    ]) ?>
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
ready = function(){
    KindEditor.ready(function(K) {
        window.editor = K.create('#posts-post_content',{
            height : '400px',
            allowFileManager : true
        });
    });
}
</script>

