var scroll_top = 0;
var $ = null;

layui.use(['form', 'laydate', 'element'], function (){
    $ = layui.jquery;
    var form = layui.form;
    var laydate = layui.laydate;
    var element = layui.element;

    // 记录页面滚动条位置
    $(document).scroll(function (){
        scroll_top = $(document).scrollTop();
    });

    // 公共日期时间范围
    laydate.render({
        elem: '.mos-common-input-datetime-range',
        type: 'datetime',
        range: '~',
        max: '23:59:59'
    });

    // 公共创建 tab
    $('.mos-common-btn-create-iframe-tab').on('click', function (){
        var obj_this = $(this);
        var title = obj_this.data('title');
        var url = obj_this.data('url');
        var parameters = obj_this.data('parameters');

        var format_url = url + (parameters ? (url.indexOf('?') != -1 ? '&' : '?') + parameters : '');

        if(window !== window.top && typeof window.top.create_tab != 'undefined')
        {
            window.top.postMessage({
                'type': 'create_tab',
                'url': format_url,
                'title': title
            }, "*");
        } else {
            window.open(format_url);
        }
    });

    // 公共表单提交
    form.on('submit(mos-common-btn-form-submit)', function (data){
        var result = $(data.elem).data('result');
        $(data.elem).addClass('layui-btn-disabled').attr('disabled', true);
        layer.load();
        $.post(data.form.action, data.field, function (response, status){
            layer.closeAll('loading');
            if(status == 'success')
            {
                if(response.status == 1000)
                {
                    layer.msg(response.msg, {icon: 1}, function (){
                        if(result == 'reload')
                        {
                            window.location.reload();
                        } else {
                            $(data.elem).removeClass('layui-btn-disabled').attr('disabled', false);
                        }
                    });
                } else {
                    layer.msg(response.msg, {icon: 2}, function (){
                        $(data.elem).removeClass('layui-btn-disabled').attr('disabled', false);
                    });
                }
            } else {
                layer.msg('请求失败', {icon: 2}, function (){
                    $(data.elem).removeClass('layui-btn-disabled').attr('disabled', false);
                });
            }
        }, 'json');
        return false;
    });

    // 公共弹层展示页面
    $('.mos-common-btn-layer-open').on('click', function (){
        var obj_this = $(this);
        var title = obj_this.data('title');
        var url = obj_this.data('url');
        var parameters = obj_this.data('parameters');
        var w = obj_this.data('width') > 0 ? obj_this.data('width') : 770;
        var h = obj_this.data('height') > 0 ? obj_this.data('height') : 530;

        var windows = window.parent;
        var format_url = url + (parameters ? (url.indexOf('?') != -1 ? '&' : '?') + parameters : '');

        windows.layer.open({
            type: 2,
            title: title,
            area: [w + 'px', h + 'px'],
            maxmin: true,
            content: format_url
        });
    });

    // 公共异步处理
    $('.mos-common-btn-ajax-get').on('click', function (){
        var obj_this = $(this);
        var url = obj_this.data('url');
        var parameters = obj_this.data('parameters');
        var result = obj_this.data('result');
        var format_url = url + (parameters ? (url.indexOf('?') != -1 ? '&' : '?') + parameters : '');
        layer.load();
        $.get(format_url, {}, function (response, status){
            layer.closeAll('loading');
            if(status == 'success')
            {
                if(response.status == 1000)
                {
                    layer.msg(response.msg, {icon: 1}, function (){
                        if(result == 'reload')
                        {
                            window.location.reload();
                        }
                    });
                } else {
                    layer.msg(response.msg, {icon: 2});
                }
            } else {
                layer.msg('请求失败', {icon: 2});
            }
        }, 'json');
    });
});