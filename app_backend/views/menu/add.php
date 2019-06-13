<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
$this->params['view_js'] = <<< EOF
<script type="text/javascript" src="/js/menu/menu.js"></script>
EOF;
?>

<form class="layui-form" action="<?php echo Html::encode(Url::to(['menu/add'])); ?>" onsubmit="return false;">
    <input type="hidden" name="<?php echo Html::encode(Yii::$app->request->csrfParam); ?>" value="<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">父级菜单</label>
        <?php foreach($menu_parents_datas as $k => $sub_datas): ?>
        <div class="layui-input-inline">
            <select name="AddForm[parent_id][<?php echo Html::encode($k); ?>]" lay-filter="menu_level" data-url="<?php echo Html::encode(Url::to(['menu/get-sub-menu-data'])); ?>" data-level="<?php echo Html::encode($k); ?>" data-form="AddForm">
                <option value="">请选择父级菜单</option>
                <?php foreach($sub_datas as $data): ?>
                <option value="<?php echo Html::encode($data['menuid']); ?>"<?php if(!empty($data['selected'])): ?> selected="selected"<?php endif; ?>><?php echo Html::encode($data['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单名</label>
        <div class="layui-input-inline">
            <input type="text" name="AddForm[name]" lay-verify="required" lay-verType="tips" placeholder="请输入菜单名" class="layui-input">
        </div>
    </div>
    <?php if(count($menu_parents_datas) > 2): ?>
    <div class="layui-form-item mos-menu-controller-action">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-inline">
            <input type="text" name="AddForm[controller]" lay-verify="required" lay-verType="tips" placeholder="请输入控制器" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item mos-menu-controller-action">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-inline">
            <input type="text" name="AddForm[action]" lay-verify="required" lay-verType="tips" placeholder="请输入方法" class="layui-input">
        </div>
    </div>
    <?php else: ?>
    <div class="layui-form-item layui-hide mos-menu-controller-action">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-inline">
            <input type="text" name="AddForm[controller]" class="layui-input" lay-verType="tips" placeholder="请输入控制器">
        </div>
    </div>
    <div class="layui-form-item layui-hide mos-menu-controller-action">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-inline">
            <input type="text" name="AddForm[action]" class="layui-input" lay-verType="tips" placeholder="请输入方法">
        </div>
    </div>
    <?php endif; ?>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="text" name="AddForm[sort]" lay-verify="required|number" lay-verType="tips" placeholder="请输入排序" class="layui-input" value="0">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写 10 的倍数值</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否显示</label>
        <div class="layui-input-inline">
            <?php foreach($is_show_k_v as $k => $v): ?>
                <input type="radio" name="AddForm[is_show]" value="<?php echo Html::encode($k); ?>" title="<?php echo Html::encode($v); ?>"<?php if($k): ?> checked="checked"<?php endif;?>>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-form-submit" data-result="reload">确认提交</button>
        </div>
    </div>
</form>