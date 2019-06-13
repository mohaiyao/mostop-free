<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
?>

<form class="layui-form" action="<?php echo Html::encode(Url::to(['setting/safe'])); ?>" onsubmit="return false;">
    <input type="hidden" name="<?php echo Html::encode(Yii::$app->request->csrfParam); ?>" value="<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>">
    <div class="layui-form-item">
        <label class="layui-form-label mos-common-width120">启用后台操作日志</label>
        <div class="layui-input-inline">
            <input type="radio" name="SettingForm[backend_enable_operate_log]" value="1" title="是"<?php if(Yii::$app->params['setting_datas']['backend_enable_operate_log']): ?> checked="checked"<?php endif;?>>
            <input type="radio" name="SettingForm[backend_enable_operate_log]" value="0" title="否"<?php if(!Yii::$app->params['setting_datas']['backend_enable_operate_log']): ?> checked="checked"<?php endif;?>>
        </div>
        <div class="layui-form-mid layui-word-aux">backend_enable_operate_log</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label mos-common-width120">启用后台删除操作</label>
        <div class="layui-input-inline">
            <input type="radio" name="SettingForm[backend_enable_delete_action]" value="1" title="是"<?php if(Yii::$app->params['setting_datas']['backend_enable_delete_action']): ?> checked="checked"<?php endif;?>>
            <input type="radio" name="SettingForm[backend_enable_delete_action]" value="0" title="否"<?php if(!Yii::$app->params['setting_datas']['backend_enable_delete_action']): ?> checked="checked"<?php endif;?>>
        </div>
        <div class="layui-form-mid layui-word-aux">backend_enable_delete_action</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label mos-common-width120">启用后台文件上传</label>
        <div class="layui-input-inline">
            <input type="radio" name="SettingForm[backend_enable_upload_file]" value="1" title="是"<?php if(Yii::$app->params['setting_datas']['backend_enable_upload_file']): ?> checked="checked"<?php endif;?>>
            <input type="radio" name="SettingForm[backend_enable_upload_file]" value="0" title="否"<?php if(!Yii::$app->params['setting_datas']['backend_enable_upload_file']): ?> checked="checked"<?php endif;?>>
        </div>
        <div class="layui-form-mid layui-word-aux">backend_enable_upload_file</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label mos-common-width120"></label>
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-form-submit">确认提交</button>
        </div>
    </div>
</form>