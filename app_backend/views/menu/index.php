<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
$this->params['view_js'] = <<< EOF
<script type="text/javascript" src="/js/table.js"></script>
EOF;
?>

<div>
    <div class="mos-common-float-left">
        <button class="layui-btn mos-common-btn-layer-open" data-title="添加菜单" data-url="<?php echo Html::encode(Url::to(['menu/add'])); ?>">添加菜单</button><button class="layui-btn layui-btn-primary mos-common-btn-ajax-get" data-url="<?php echo Html::encode(Url::to(['menu/repair'])); ?>">修复菜单</button><button class="layui-btn layui-btn-primary mos-common-btn-table-refresh" data-tableid="mos-table-menu" data-page="false" title="刷新"><i class="layui-icon layui-icon-refresh-3"></i></button>
    </div>
    <div class="layui-clear"></div>
</div>

<!-- 数据列表 -->
<table id="mos-table-menu" lay-filter="mos-table" data-url="<?php echo Html::encode(Url::to(['menu/index'])); ?>"></table>

<!-- 菜单名处理 -->
<script type="text/html" id="mos-table-menu-col-name">
    <span style="margin-left: {{ d.level * 30 }}px;">{{ d.name }}</span>
</script>

<!-- 访问地址处理 -->
<script type="text/html" id="mos-table-menu-col-url">
    {{# if(d.controller && d.action){ }}
    /{{ d.controller }}/{{ d.action }}.html
    {{# } }}
</script>

<!-- 状态处理 -->
<script type="text/html" id="mos-table-menu-col-enabled">
    {{# if(d.enabled === '1'){ }}
    <span style="color: #5FB878;">{{ d.enabled_desc }}</span>
    {{# } else if(d.enabled === '0') { }}
    <span style="color: #FF5722;">{{ d.enabled_desc }}</span>
    {{# } }}
</script>

<!-- 显示处理 -->
<script type="text/html" id="mos-table-menu-col-is-show">
    {{# if(d.is_show === '1'){ }}
    <span style="color: #5FB878;">{{ d.is_show_desc }}</span>
    {{# } else if(d.is_show === '0') { }}
    <span style="color: #FF5722;">{{ d.is_show_desc }}</span>
    {{# } }}
</script>

<!-- 操作按钮 -->
<script type="text/html" id="mos-table-bar">
    {{# if(d.level < 3){ }}<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="mos-common-btn-layer-open" data-title="添加子菜单" data-url="<?php echo Html::encode(Url::to(['menu/add'])); ?>" data-parameters="menuid={{ d.menuid }}" title="添加子菜单"><i class="layui-icon layui-icon-add-1"></i></a>{{# } }}<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="mos-common-btn-layer-open" data-title="编辑菜单" data-url="<?php echo Html::encode(Url::to(['menu/edit'])); ?>" data-parameters="menuid={{ d.menuid }}" data-width="800" data-height="630" title="编辑"><i class="layui-icon layui-icon-edit"></i></a><a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="mos-common-btn-layer-confirm" data-title="确定删除菜单 ID = {{ d.menuid }} 及其下属所有菜单的记录吗？" data-url="<?php echo Html::encode(Url::to(['menu/del'])); ?>" data-parameters="menuid={{ d.menuid }}" data-result="reload" title="删除"><i class="layui-icon layui-icon-delete"></i></a>
</script>