layui.use(['form'], function (){
    var common = layui.common;
    var $ = layui.jquery;
    var form = layui.form;

    // 登录验证
    form.verify({
        'LoginForm[username]': function (username){
            if(!common.verify_username(username))
            {
                return common.get_verify_username_desc();
            }
        },
        'LoginForm[password]': function (password){
            if(!common.verify_password(password))
            {
                return common.get_verify_password_desc();
            }
        }
    });

    // 登录提交
    form.on('submit(login)', function (data){
        $(data.elem).addClass('layui-btn-disabled').attr('disabled', true);
        layer.load();
        $.post(data.form.action, data.field, function (response, status){
            layer.closeAll('loading');
            if(status == 'success')
            {
                if(response.status == 1000)
                {
                    layer.msg(response.msg, {icon: 1}, function (){
                        window.top.location.href = '/';
                    });
                } else {
                    layer.msg(response.msg, {icon: 2}, function (){
                        $(data.elem).removeClass('layui-btn-disabled').attr('disabled', false);
                        $('#mos-login-form-captcha-img').click();
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

    // 更换验证码
    $('#mos-login-form-captcha-img').on('click', function (){
        var obj_this = $(this);
        layer.load();
        $.get(obj_this.data('url') + '?refresh', {}, function (response, status){
            layer.closeAll('loading');
            if(status == 'success')
            {
                obj_this.attr('src', response.url);
            } else {
                layer.msg('请求失败', {icon: 2});
            }
        }, 'json');
    });
});