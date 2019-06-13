<?php

namespace common\helpers;

class Common
{
    /**
     * 格式化打印数据
     * @param $data 输出的数据
     * @param bool $exit 是否终止程序，true | false
     */
    public static function printR($data, $exit = true)
    {
        header('Content-type: text/html; charset=utf-8');
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        $exit && exit;
    }

    /**
     * 返回 json 数据
     * @param $status
     * @param string $msg
     * @param array $data
     * @param null $count
     * @return string
     */
    public static function echoJson($status, $msg = '', $data = [], $count = null)
    {
        $json = [
            'status' => $status,
            'msg' => $msg,
        ];
        $data && $json['data'] = $data;
        $count !== null && $json['count'] = $count;

        $json_string = json_encode($json, JSON_UNESCAPED_UNICODE);

        $cross_domain = isset($_GET['callback']) ? $_GET['callback'] : '';
        $cross_domain && $json_string = $cross_domain . '(' . $json_string . ')';

        return $json_string;
    }

    /**
     * 计算用户名对应所在的表
     * @param $username
     * @param int $total_table
     * @param string $table_prefix
     * @return string
     */
    public static function subTable($username, $total_table = 5, $table_prefix = 'mostop_user_')
    {
        $username = strtolower($username); // 用户名小写
        $first_char = substr($username, 0, 1); // 获取第一个字符
        $last_char = substr($username, -1); // 获取最后一个字符

        $sum = ord($first_char) + ord($last_char); // 将第一个字符及最后一个字符的 ASCII 码求和

        $str_length = strlen($username); // 用户名字符长度
        $sum += $str_length * $str_length; // 根据用户名字符长度增大 ASCII 码的值，使得不同用户名所在的表跨度增大

        $find_num = $sum % $total_table; // 计算用户名所在的表

        return $table_prefix . $find_num;
    }

    /**
     * 随机生成指定位数的字符串
     * @param int $length
     * @return string
     */
    public static function randChars($length = 6)
    {
        $chars = str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        $chars_length = strlen($chars);
        $rand_chars = '';
        for($i = 0; $i < $length; $i++)
        {
            $rand_num = mt_rand(0, $chars_length - 1);
            $rand_chars .= substr($chars, $rand_num, 1);
        }
        return $rand_chars;
    }

    /**
     * 生成密码
     * @param $password
     * @param $salt
     * @return string
     */
    public static function createPassword($password, $salt)
    {
        return md5(md5(base64_encode($password) . base64_encode($salt)));
    }

    /**
     * 时间戳转日期格式
     * @param $time
     * @param string $format
     * @return false|string
     */
    public static function dateFormat($time, $format = 'Y-m-d H:i:s')
    {
        $time = intval($time);
        return $time ? date($format, $time) : '';
    }
}