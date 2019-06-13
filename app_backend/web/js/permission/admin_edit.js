layui.use(['form'], function (){
    var $ = layui.jquery;
    var common = layui.common;
    var form = layui.form;

    form.verify({
        'AdminEditForm[new_password]': function (password){
            if(password && !common.verify_password(password))
            {
                return common.get_verify_password_desc();
            }
        }
    });
});