<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
?>

<form class="layui-form" action="<?php echo Html::encode(Url::to(['setting/cache'])); ?>" onsubmit="return false;">
    <input type="hidden" name="<?php echo Html::encode(Yii::$app->request->csrfParam); ?>" value="<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">缓存时间</label>
        <div class="layui-input-inline">
            <input type="text" name="SettingForm[system_cache_time]" lay-verify="required|number" lay-verType="tips" placeholder="请输入缓存时间" class="layui-input" value="<?php echo Html::encode(Yii::$app->params['setting_datas']['system_cache_time']); ?>">
        </div>
        <div class="layui-form-mid layui-word-aux">秒</div>
        <div class="layui-form-mid layui-word-aux">system_cache_time</div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-form-submit">确认提交</button>
        </div>
    </div>
</form>