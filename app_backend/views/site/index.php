<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php echo Html::encode(Yii::$app->charset); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <?php echo Html::csrfMetaTags(); ?>
    <title><?php echo Html::encode($title . ' - ' . Yii::$app->name); ?></title>
        <link type="text/css" rel="stylesheet" href="/lib/layui/css/layui.css" />
    <link type="text/css" rel="stylesheet" href="/css/index.css" />
</head>
<?php $this->beginBody(); ?>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo"><a href="/"><?php echo Html::encode(Yii::$app->name); ?></a></div>
        <ul class="layui-nav layui-layout-left mos-index-menu-nav" lay-filter="menu">
            <?php foreach($admin_menu_datas['top'] as $k => $data): ?>
            <li class="layui-nav-item<?php if(!$k): ?> layui-this<?php endif; ?>"><a href="javascript:;" data-menu="<?php echo Html::encode($data['menuid']); ?>"><?php echo Html::encode($data['name']); ?></a></li>
            <?php endforeach; ?>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <?php if($admin_data['avatar']): ?>
                    <img src="<?php echo Html::encode($admin_data['avatar']); ?>" class="layui-nav-img">
                    <?php else: ?>
                    <img src="/lib/img/avatar.png" class="layui-nav-img">
                    <?php endif; ?>
                    <?php echo Html::encode($admin_data['user']['username']); ?><?php if($admin_data['name']): ?>（<?php echo Html::encode($admin_data['name']); ?>）<?php endif; ?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo Html::encode(Url::to(['site/logout'])); ?>">退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree mos-index-side-nav" lay-filter="side">
                <?php foreach($admin_menu_datas['left'] as $k => $data): ?>
                <li class="layui-nav-item layui-nav-itemed" data-menu="<?php echo Html::encode($data['parent_id']); ?>">
                    <a href="javascript:;"><?php echo Html::encode($data['name']); ?></a>
                    <dl class="layui-nav-child">
                        <?php foreach($data['sub_menu'] as $sub_data): ?>
                        <dd><a href="javascript:;" data-url="<?php echo Html::encode(Url::to([$sub_data['controller'] . '/' . $sub_data['action']])); ?>"><?php echo Html::encode($sub_data['name']); ?></a></dd>
                        <?php endforeach; ?>
                    </dl>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="layui-body">
        <div class="layui-tab" lay-allowClose="true" lay-filter="tab">
            <ul class="layui-tab-title">
                <li class="layui-this"><span data-url="<?php echo Html::encode(Url::to(['site/home'])); ?>">后台首页</span></li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show"><iframe src="<?php echo Html::encode(Url::to(['site/home'])); ?>"></iframe></div>
            </div>
        </div>
    </div>
    <div class="layui-footer">© <?php echo Html::encode(date('Y')); ?> <a href="<?php echo Html::encode(Yii::$app->params['system_url']); ?>" target="_blank"><?php echo Html::encode(Yii::$app->params['system_url']); ?></a></div>
    <a href="javascript:;" class="mos-index-fold-expand"><i class="layui-icon layui-icon-shrink-right"></i></a>
</div>
<ul class="layui-nav layui-nav-tree mos-index-tab-right-click" lay-filter="tab-right">
    <li class="layui-nav-item layui-nav-itemed">
        <dl class="layui-nav-child">
            <dd><a href="javascript:;" data-type="hide">关闭右击菜单</a></dd>
            <dd><a href="javascript:;" data-type="refresh">刷新标签页</a></dd>
            <dd><a href="javascript:;" data-type="close">关闭标签页</a></dd>
            <dd><a href="javascript:;" data-type="close_other">关闭其它标签页</a></dd>
            <dd><a href="javascript:;" data-type="close_all">关闭全部标签页</a></dd>
            <dd><a href="javascript:;" data-type="link">新窗口打开链接</a></dd>
        </dl>
    </li>
</ul>
<script type="text/javascript" src="/lib/layui/layui.js"></script>
<script type="text/javascript" src="/lib/js/common.js"></script>
<script type="text/javascript" src="/js/index.js"></script>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>