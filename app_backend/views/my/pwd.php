<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
$this->params['view_js'] = <<< EOF
<script type="text/javascript" src="/js/my/pwd.js"></script>
EOF;
?>

<form class="layui-form" action="<?php echo Html::encode(Url::to(['my/pwd'])); ?>" onsubmit="return false;">
    <input type="hidden" name="<?php echo Html::encode(Yii::$app->request->csrfParam); ?>" value="<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">原密码</label>
        <div class="layui-input-inline">
            <input type="password" name="PwdForm[old_password]" lay-verify="required|PwdForm[old_password]" placeholder="请输入原密码" class="layui-input" lay-verType="tips">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新密码</label>
        <div class="layui-input-inline">
            <input type="password" name="PwdForm[password]" lay-verify="required|PwdForm[password]" placeholder="请输入新密码" class="layui-input" lay-verType="tips">
        </div>
        <div class="layui-form-mid layui-word-aux mos-my-pwd-word"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">确认新密码</label>
        <div class="layui-input-inline">
            <input type="password" name="PwdForm[check_password]" lay-verify="required|PwdForm[check_password]" placeholder="请输入确认新密码" class="layui-input" lay-verType="tips">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-form-submit" data-result="reload">确认提交</button>
        </div>
    </div>
</form>