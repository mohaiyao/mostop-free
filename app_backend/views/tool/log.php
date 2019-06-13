<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $title;
$this->params['view_js'] = <<< EOF
<script type="text/javascript" src="/js/table.js"></script>
EOF;
?>

<!-- 数据列表 -->
<table id="mos-table-log" lay-filter="mos-table" data-url="<?php echo Html::encode(Url::to(['tool/log'])); ?>"></table>