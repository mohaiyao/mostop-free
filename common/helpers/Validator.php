<?php

namespace common\helpers;

class Validator
{
    public static $error;

    /**
     * 验证用户名
     * @param $username
     * @return bool
     */
    public static function username($username)
    {
        if(preg_match('/^[a-zA-Z][a-zA-Z0-9_]{3,13}[a-zA-Z0-9]$/', $username) || preg_match('/^1\d{10}$/', $username) || preg_match('/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/', $username))
        {
            return true;
        }
        self::$error = '手机、邮箱或 5 ~ 15 位字母、数字、下划线组成，不能以数字下划线开头或者下划线结尾';
        return false;
    }

    /**
     * 验证密码
     * @param $password
     * @return bool
     */
    public static function password($password)
    {
        if(!preg_match('/^.{6,20}$/', $password))
        {
            self::$error = '密码由 6 ~ 20 位字符组成';
            return false;
        }
        return true;
    }
}