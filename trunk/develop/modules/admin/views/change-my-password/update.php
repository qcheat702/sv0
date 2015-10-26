<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserProductStep */

$this->title = '修改密码';
$this->params['breadcrumbs'][] = ['label' => '查看个人资料', 'url' => ['my-infor/view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-change-my-password-update">

<div class="panel panel-default">
<div class="panel-heading" data-toggle="collapse" href="#collapse01"><span class="glyphicon glyphicon-eye-close"></span>    <?= Html::encode($this->title) ?></div>
<div class="panel-body collapse in" id="collapse01">

    <div class="member-change-my-password-update-form">
	    <?php $form = ActiveForm::begin(); ?>

	     <?= $form->field($model, 'passwordo')->passwordInput() ?>
	     <?= $form->field($model, 'passwordn')->passwordInput() ?>
	     <?= $form->field($model, 'passwordr')->passwordInput() ?>

	    <div class="form-group">
	        <?= Html::submitButton('更新', ['class' => 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div></div></div>

</div>

