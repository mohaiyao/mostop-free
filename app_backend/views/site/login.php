<?php
use yii\helpers\Url;
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
    <title><?php echo Html::encode($title . ' - ' . Yii::$app->name); ?></title>
        <link type="text/css" rel="stylesheet" href="/lib/layui/css/layui.css" />
    <link type="text/css" rel="stylesheet" href="/css/login.css" />
</head>
<body>
<?php $this->beginBody(); ?>
<form class="layui-form mos-login-form" action="<?php echo Html::encode(Url::to(['site/login'])); ?>" onsubmit="return false;">
    <input type="hidden" name="<?php echo Html::encode(Yii::$app->request->csrfParam); ?>" value="<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>">
    <div class="mos-login-form-title"><?php echo Html::encode(Yii::$app->name); ?></div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <i class="layui-icon layui-icon-username"></i>
            <input type="text" name="LoginForm[username]" lay-verify="required|LoginForm[username]" placeholder="用户名" class="layui-input" lay-verType="tips">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <i class="layui-icon layui-icon-password"></i>
            <input type="password" name="LoginForm[password]" lay-verify="required|LoginForm[password]" placeholder="密码" class="layui-input" lay-verType="tips">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-inline">
            <i class="layui-icon layui-icon-vercode"></i>
            <input type="text" name="LoginForm[verify_code]" lay-verify="required" placeholder="验证码" class="layui-input" lay-verType="tips">
        </div>
        <div class="mos-login-form-captcha"><img id="mos-login-form-captcha-img" src="<?php echo Html::encode(Url::to(['site/captcha'])); ?>" data-url="<?php echo Html::encode(Url::to(['site/captcha'])); ?>" alt="验证码" title="更换验证码"></div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="login">登录</button>
        </div>
    </div>
</form>
<script type="text/javascript" src="/lib/layui/layui.js"></script>
<script type="text/javascript" src="/lib/js/common.js"></script>
<script type="text/javascript" src="/js/login.js"></script>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>