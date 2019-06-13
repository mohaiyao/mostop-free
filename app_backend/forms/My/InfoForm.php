<?php

namespace app_backend\forms\My;

use Yii;
use yii\base\Model;

use app_backend\models\AdminExtends;

class InfoForm extends Model
{
    public $name;
    public $sex;
    public $birthday;
    public $avatar;
    public $mobile;
    public $email;
    public $qq;
    public $weixin;

    public function rules()
    {
        return [
            [['sex'], 'integer'],
            [['birthday'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['avatar', 'email'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 11],
            [['qq', 'weixin'], 'string', 'max' => 15],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '姓名',
            'sex' => '性别',
            'birthday' => '生日',
            'avatar' => '头像',
            'mobile' => '手机',
            'email' => '邮箱',
            'qq' => 'QQ',
            'weixin' => '微信',
        ];
    }

    public function save()
    {
        if($this->validate())
        {
            $Admin = AdminExtends::findOne(Yii::$app->user->id);
            foreach($this->getAttributes() as $field => $value)
            {
                $Admin->{$field} = $value;
            }
            return $Admin->save();
        }
        return false;
    }
}