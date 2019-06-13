<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
$this->params['view_js'] = <<< EOF
<script type="text/javascript" src="/js/permission/admin_edit.js"></script>
EOF;
?>

<form class="layui-form" action="<?php echo Html::encode(Url::to(['permission/admin-edit', 'userid' => $admin_data['userid']])); ?>" onsubmit="return false;">
    <input type="hidden" name="<?php echo Html::encode(Yii::$app->request->csrfParam); ?>" value="<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">用户 ID</label>
        <div class="layui-form-mid layui-word-aux"><?php echo Html::encode($admin_data['userid']); ?></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-form-mid layui-word-aux"><?php echo Html::encode($admin_data['user']['username']); ?></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
            <input type="text" name="AdminEditForm[password]" lay-verify="AdminEditForm[new_password]" lay-verType="tips" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">密码为空时不更新密码</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-inline">
            <input type="text" name="AdminEditForm[name]" lay-verify="required" lay-verType="tips" placeholder="请输入姓名" class="layui-input" value="<?php echo Html::encode($admin_data['name']); ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">性别</label>
        <div class="layui-input-inline">
            <?php foreach($sex_k_v as $k => $v): ?>
            <input type="radio" name="AdminEditForm[sex]" value="<?php echo Html::encode($k); ?>" title="<?php echo Html::encode($v); ?>"<?php if($admin_data['sex'] == $k): ?> checked="checked"<?php endif; ?>>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-inline mos-common-width300">
            <?php foreach($disabled_k_v as $k => $v): ?>
            <input type="radio" name="AdminEditForm[disabled]" value="<?php echo Html::encode($k); ?>" title="<?php echo Html::encode($v); ?>"<?php if($admin_data['disabled'] == $k): ?> checked="checked"<?php endif; ?>>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-form-submit" data-result="reload">确认提交</button>
        </div>
    </div>
</form>