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
            <label class="layui-form-label">登录名</label>
            <div class="layui-input-inline">
                <input type="text" name="search[username]" class="layui-input">
            </div>
            <label class="layui-form-label">登录 IP</label>
            <div class="layui-input-inline">
                <input type="text" name="search[ip]" class="layui-input">
            </div>
            <label class="layui-form-label mos-common-width120">登录时间范围</label>
            <div class="layui-input-inline mos-common-width300">
                <input type="text" name="search[created_at]" class="layui-input mos-common-input-datetime-range" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="layui-form-item mos-common-margin-bottom0">
        <div class="layui-input-block mos-common-margin-left0">
            <button class="layui-btn" lay-submit="" lay-filter="mos-common-btn-table-search" data-tableid="mos-table-login-log">搜索</button><button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<!-- 数据列表 -->
<table id="mos-table-login-log" lay-filter="mos-table" data-url="<?php echo Html::encode(Url::to(['tool/login-log'])); ?>"></table>

<!-- 登陆情况 -->
<script type="text/html" id="mos-table-login-log-col-succeed">
    {{# if(d.succeed === '1'){ }}
    <span style="color: #5FB878;">{{ d.succeed_desc }}</span>
    {{# } else if(d.succeed === '0') { }}
    <span style="color: #FF5722;">{{ d.succeed_desc }}</span>
    {{# } }}
</script>