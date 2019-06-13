layui.use(['layer'], function(){
    var layer = layui.layer;
    var $ = layui.jquery;

    $('.mos-site-home-layui').html(layui.v);

    $('#mos-site-home-wechat').on('click', function (){
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '350px',
            skin: 'layui-layer-nobg',
            shadeClose: true,
            content: $('#mos-site-home-wechat-img').html()
        });
    });
});