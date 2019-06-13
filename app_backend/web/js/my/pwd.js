layui.use(['form'], function (){
    var $ = layui.jquery;
    var common = layui.common;
    var form = layui.form;

    $('.mos-my-pwd-word').html(common.get_verify_password_desc());
    form.verify({
        'PwdForm[old_password]': function (password){
            if(!common.verify_password(password))
            {
                return common.get_verify_password_desc();
            }
        },
        'PwdForm[password]': function (password){
            if(!common.verify_password(password))
            {
                return common.get_verify_password_desc();
            }
        },
        'PwdForm[check_password]': function (password){
            if(!common.verify_password(password))
            {
                return common.get_verify_password_desc();
            } else if(password != $('input[name="PwdForm[password]"]').val()) {
                return '确认新密码错误';
            }
        }
    });
});