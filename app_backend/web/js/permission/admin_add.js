layui.use(['form'], function (){
    var $ = layui.jquery;
    var common = layui.common;
    var form = layui.form;

    form.verify({
        'AdminAddForm[username]': function (username){
            if(!common.verify_username(username))
            {
                return common.get_verify_username_desc();
            }
        },
        'AdminAddForm[password]': function (password){
            if(!common.verify_password(password))
            {
                return common.get_verify_password_desc();
            }
        }
    });
});