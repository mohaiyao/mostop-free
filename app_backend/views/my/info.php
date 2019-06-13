<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
$this->params['view_css'] = <<< EOF
<link type="text/css" rel="stylesheet" href="/css/my/info.css">
EOF;
$this->params['view_js'] = <<< EOF
<script type="text/javascript" src="/js/my/info.js"></script>
EOF;
?>

<form class="layui-form" action="<?php echo Html::encode(Url::to(['my/info'])); ?>" onsubmit="return false;">
    <input type="hidden" name="<?php echo Html::encode(Yii::$app->request->csrfParam); ?>" value="<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>">
    <input type="hidden" name="InfoForm[avatar]" id="mos-my-info-avatar-hidden" value="<?php echo Html::encode($admin_data['avatar']); ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">头像</label>
        <div class="layui-input-inline">
            <div>
                <?php if($admin_data['avatar']): ?>
                <img src="<?php echo Html::encode($admin_data['avatar']); ?>" class="layui-circle" id="mos-my-info-avatar">
                <?php else: ?>
                <img src="/lib/img/avatar.png" class="layui-circle" id="mos-my-info-avatar">
                <?php endif; ?>
                <p id="mos-my-info-avatar-upload-error"></p>
            </div>
            <button type="button" class="layui-btn" id="mos-my-info-avatar-btn" lay-data="{url: '<?php echo Html::encode(Url::to(['public/upload'])); ?>', accept: 'images', data: {'<?php echo Html::encode(Yii::$app->request->csrfParam); ?>': '<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>', 'file_field': 'image_file', 'file_dir': 'avatar'}, size: 100, field: 'UploadForm[image_file]'}"><i class="layui-icon layui-icon-upload"></i>上传图片</button>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-inline">
            <input type="text" name="InfoForm[name]" class="layui-input" value="<?php echo Html::encode($admin_data['name']); ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">性别</label>
        <div class="layui-input-inline">
            <?php foreach($sex_k_v as $k => $v): ?>
            <input type="radio" name="InfoForm[sex]" value="<?php echo Html::encode($k); ?>" title="<?php echo Html::encode($v); ?>"<?php if($admin_data['sex'] == $k): ?> checked="checked"<?php endif; ?>>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">生日</label>
        <div class="layui-input-inline">
            <input type="text" name="InfoForm[birthday]" id="mos-my-info-birthday" class="layui-input" readonly="readonly" value="<?php echo Html::encode($admin_data['birthday']); ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机</label>
        <div class="layui-input-inline">
            <input type="text" name="InfoForm[mobile]" class="layui-input" value="<?php echo Html::encode($admin_data['mobile']); ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-inline">
            <input type="text" name="InfoForm[email]" class="layui-input" value="<?php echo Html::encode($admin_data['email']); ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">QQ</label>
        <div class="layui-input-inline">
            <input type="text" name="InfoForm[qq]" class="layui-input" value="<?php echo Html::encode($admin_data['qq']); ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">微信</label>
        <div class="layui-input-inline">
            <input type="text" name="InfoForm[weixin]" class="layui-input" value="<?php echo Html::encode($admin_data['weixin']); ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-form-submit">确认提交</button>
        </div>
    </div>
</form>