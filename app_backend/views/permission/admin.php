<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
$this->params['view_js'] = <<< EOF
<script type="text/javascript" src="/js/table.js"></script>
EOF;
?>

<form class="layui-form layui-form-pane" onsubmit="return false;">
    <div class="layui-form-item mos-common-margin-bottom10">
        <div class="layui-inline mos-common-margin-bottom0 mos-common-margin-right0">
            <label class="layui-form-label">用户 ID</label>
            <div class="layui-input-inline">
                <input type="text" name="search[userid]" class="layui-input">
            </div>
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-inline">
                <input type="text" name="search[username]" class="layui-input">
            </div>
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="search[name]" class="layui-input">
            </div>
        </div>
    </div>
    <div class="layui-form-item mos-common-margin-bottom10">
        <div class="layui-inline mos-common-margin-bottom0 mos-common-margin-right0">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-inline">
                <select name="search[disabled]">
                    <option value="">请选择状态</option>
                    <?php foreach($disabled_k_v as $k => $v): ?>
                    <option value="<?php echo Html::encode($k); ?>"><?php echo Html::encode($v); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="layui-form-item mos-common-margin-bottom0">
        <div class="layui-input-block mos-common-margin-left0">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-table-search" data-tableid="mos-table-admin">搜索</button><button type="reset" class="layui-btn layui-btn-primary">重置</button><button class="layui-btn mos-common-btn-layer-open" data-title="添加管理员" data-url="<?php echo Html::encode(Url::to(['permission/admin-add'])); ?>">添加管理员</button><button class="layui-btn layui-btn-primary mos-common-btn-table-refresh" data-tableid="mos-table-admin" data-page="current" title="刷新"><i class="layui-icon layui-icon-refresh-3"></i></button>
        </div>
    </div>
</form>

<!-- 数据列表 -->
<table id="mos-table-admin" lay-filter="mos-table" data-url="<?php echo Html::encode(Url::to(['permission/admin'])); ?>"></table>

<!-- 是否系统默认角色处理 -->
<script type="text/html" id="mos-table-admin-col-disabled">
    {{# if(d.disabled === '1'){ }}
    <span style="color: #FF5722;">{{ d.disabled_desc }}</span>
    {{# } else if(d.disabled === '0') { }}
    <span style="color: #5FB878;">{{ d.disabled_desc }}</span>
    {{# } }}
</script>

<!-- 操作按钮 -->
<script type="text/html" id="mos-table-bar">
    {{# if(d.userid !== '1'){ }}<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="mos-common-btn-layer-open" data-title="编辑管理员" data-url="<?php echo Html::encode(Url::to(['permission/admin-edit'])); ?>" data-parameters="userid={{ d.userid }}" data-width="800" data-height="600" title="编辑"><i class="layui-icon layui-icon-edit"></i></a>{{# if(d.disabled === '0'){ }}<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="mos-common-btn-layer-confirm" data-title="确定删除用户 ID = {{ d.userid }} 的记录吗？" data-url="<?php echo Html::encode(Url::to(['permission/admin-del'])); ?>" data-parameters="userid={{ d.userid }}" data-result="refresh" title="删除"><i class="layui-icon layui-icon-delete"></i></a>{{# } }}{{# } }}
</script>