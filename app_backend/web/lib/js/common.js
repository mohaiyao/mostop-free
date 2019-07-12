layui.define(function (exports){
    var common =
    {
        /**
         * 验证用户名
         * @param username
         * @returns {boolean}
         */
        verify_username: function (username){
            var rule_username = /^[a-zA-Z][a-zA-Z0-9_]{3,13}[a-zA-Z0-9]$/;
            var rule_mobile = /^1\d{10}$/;
            var rule_email = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
            if(rule_username.test(username) || rule_mobile.test(username) || rule_email.test(username))
            {
                return true;
            }
            return false;
        },
        /**
         * 获取用户名验证规则描述
         * @returns {string}
         */
        get_verify_username_desc: function (){
            var rule_desc = '手机、邮箱或 5 ~ 15 位字母、数字、下划线组成，不能以数字下划线开头或者下划线结尾';
            return rule_desc;
        },
        /**
         * 验证密码
         * @param password
         * @returns {boolean}
         */
        verify_password: function (password){
            var rule = /^.{6,20}$/;
            if(password && rule.test(password))
            {
                return true;
            }
            return false;
        },
        /**
         * 获取密码验证规则描述
         * @returns {string}
         */
        get_verify_password_desc: function (){
            var rule_desc = '密码由 6 ~ 20 位字符组成';
            return rule_desc;
        }
    };

    exports('common', common);
});