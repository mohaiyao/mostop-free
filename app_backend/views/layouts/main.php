<?php
use yii\helpers\Html;
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php echo Html::encode(Yii::$app->charset); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <?php echo Html::csrfMetaTags(); ?>
    <title><?php echo Html::encode($this->title . ' - ' . Yii::$app->name); ?></title>
        <link type="text/css" rel="stylesheet" href="/lib/layui/css/layui.css" />
    <link type="text/css" rel="stylesheet" href="/css/main.css" />
    <?php echo $this->params['view_css']; ?>
</head>
<body>
<?php $this->beginBody(); ?>
<div class="mos-common-container">
    <?php echo $content; ?>
</div>
<script type="text/javascript" src="/lib/layui/layui.js"></script>
<script type="text/javascript" src="/lib/js/common.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<?php echo $this->params['view_js']; ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>