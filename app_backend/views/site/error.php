<?php
$this->context->layout = false;
use yii\helpers\Html;
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php echo Html::encode(Yii::$app->charset); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title><?php echo Html::encode('404 - ' . Yii::$app->name); ?></title>
        <link type="text/css" rel="stylesheet" href="/lib/layui/css/layui.css" />
    <link type="text/css" rel="stylesheet" href="/lib/css/error.css" />
</head>
<body>
<?php $this->beginBody(); ?>
<div class="mos-error-container">
    <div class="mos-error-img">
        <img src="/lib/img/404.jpg">
    </div>
    <div class="mos-error-button">
        <a href="/" class="layui-btn">返回后台</a>
    </div>
</div>
<script type="text/javascript" src="/lib/layui/layui.js"></script>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>