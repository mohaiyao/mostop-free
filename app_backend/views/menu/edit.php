<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
$this->params['view_js'] = <<< EOF
<script type="text/javascript" src="/js/menu/menu.js"></script>
EOF;
?>

<form class="layui-form" action="<?php echo Html::encode(Url::to(['menu/edit', 'menuid' => $menu_data['menuid']])); ?>" onsubmit="return false;">
    <input type="hidden" name="<?php echo Html::encode(Yii::$app->request->csrfParam); ?>" value="<?php echo Html::encode(Yii::$app->request->getCsrfToken()); ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">菜单 ID</label>
        <div class="layui-form-mid layui-word-aux"><?php echo Html::encode($menu_data['menuid']); ?></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">父级菜单</label>
        <?php foreach($menu_parents_datas as $k => $sub_datas): ?>
        <div class="layui-input-inline">
            <select name="EditForm[parent_id][<?php echo Html::encode($k); ?>]" lay-filter="menu_level" data-url="<?php echo Html::encode(Url::to(['menu/get-sub-menu-data', 'except_menuid' => $menu_data['menuid']])); ?>" data-level="<?php echo Html::encode($k); ?>" data-form="EditForm">
                <option value="">请选择父级菜单</option>
                <?php foreach($sub_datas as $data): ?>
                <?php if($data['menuid'] != $menu_data['menuid']): ?>
                <option value="<?php echo Html::encode($data['menuid']); ?>"<?php if(!empty($data['selected'])): ?> selected="selected"<?php endif;?>><?php echo Html::encode($data['name']); ?></option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单名</label>
        <div class="layui-input-inline">
            <input type="text" name="EditForm[name]" lay-verify="required" lay-verType="tips" placeholder="请输入菜单名" class="layui-input" value="<?php echo Html::encode($menu_data['name']); ?>">
        </div>
    </div>
    <?php if(count($menu_parents_datas) > 2): ?>
    <div class="layui-form-item mos-menu-controller-action">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-inline">
            <input type="text" name="EditForm[controller]" lay-verify="required" lay-verType="tips" placeholder="请输入控制器" class="layui-input" value="<?php echo Html::encode($menu_data['controller']); ?>">
        </div>
    </div>
    <div class="layui-form-item mos-menu-controller-action">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-inline">
            <input type="text" name="EditForm[action]" lay-verify="required" lay-verType="tips" placeholder="请输入方法" class="layui-input" value="<?php echo Html::encode($menu_data['action']); ?>">
        </div>
    </div>
    <?php else: ?>
    <div class="layui-form-item layui-hide mos-menu-controller-action">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-inline">
            <input type="text" name="EditForm[controller]" class="layui-input" lay-verType="tips">
        </div>
    </div>
    <div class="layui-form-item layui-hide mos-menu-controller-action">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-inline">
            <input type="text" name="EditForm[action]" class="layui-input" lay-verType="tips">
        </div>
    </div>
    <?php endif; ?>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="text" name="EditForm[sort]" lay-verify="required|number" lay-verType="tips" placeholder="请输入排序" class="layui-input" value="<?php echo Html::encode($menu_data['sort']); ?>">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写 10 的倍数值</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否启用</label>
        <div class="layui-input-inline">
            <?php foreach($enabled_k_v as $k => $v): ?>
            <input type="radio" name="EditForm[enabled]" value="<?php echo Html::encode($k); ?>" title="<?php echo Html::encode($v); ?>"<?php if($menu_data['enabled'] == $k): ?> checked="checked"<?php endif;?><?php if($k == 1 && $parent_menu_data && !$parent_menu_data['enabled']): ?> disabled="disabled"<?php endif;?>>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否显示</label>
        <div class="layui-input-inline">
            <?php foreach($is_show_k_v as $k => $v): ?>
            <input type="radio" name="EditForm[is_show]" value="<?php echo Html::encode($k); ?>" title="<?php echo Html::encode($v); ?>"<?php if($menu_data['is_show'] == $k): ?> checked="checked"<?php endif;?>>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-form-submit">确认提交</button>
        </div>
    </div>
</form>