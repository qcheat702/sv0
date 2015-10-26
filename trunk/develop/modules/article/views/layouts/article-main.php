<?php
use yii\helpers\Html;
use yii\helpers\Url;
    // sv\article\assets
use sv\article\assets\ArticleAsset;
ArticleAsset::register($this);

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->params['title']) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header></header>
<?=$content?>    

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
