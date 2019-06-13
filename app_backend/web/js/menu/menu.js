layui.use(['form'], function (){
    var $ = layui.jquery;
    var form = layui.form;

    function menu_level(data)
    {
        var level = $(data.elem).data('level');
        $(data.elem).parent('.layui-input-inline').nextAll('.layui-input-inline').remove();
        if((data.value > 0 && level == 1) || level == 2)
        {
            $('.mos-menu-controller-action').removeClass('layui-hide').addClass('layui-show').find('input').attr('lay-verify', 'required');
        } else {
            $('.mos-menu-controller-action').removeClass('layui-show').addClass('layui-hide').find('input').removeAttr('lay-verify');
        }
        if(data.value > 0 && level <= 1)
        {
            var get_url = $(data.elem).data('url');
            var get_form = $(data.elem).data('form');
            layer.load();
            $.get(get_url + (get_url.indexOf('?') != -1 ? '&' : '?') + 'parent_id=' + data.value, {}, function (response, status){
                layer.closeAll('loading');
                if(status == 'success')
                {
                    if(response.status == 1000)
                    {
                        var select_option = '<div class="layui-input-inline"><select name="' + get_form + '[parent_id][' + (level + 1) + ']" lay-filter="menu_level" data-url="' + get_url + '" data-level="' + (level + 1) + '" data-form="' + get_form + '"><option value="">请选择父级菜单</option>';
                        $.each(response.data, function (k, v){
                            select_option += '<option value="' + v.menuid + '">' + v.name + '</option>';
                        });
                        select_option += '</select></div>';
                        $(data.elem).parent('.layui-input-inline').after(select_option);
                        form.render('select');
                        form.on('select(menu_level)', function (new_data){
                            menu_level(new_data);
                        });
                    } else {
                        layer.msg(response.msg, {icon: 2});
                    }
                } else {
                    layer.msg('请求失败', {icon: 2});
                }
            }, 'json');
        }
    }
    form.on('select(menu_level)', function (data){
        menu_level(data);
    });
});