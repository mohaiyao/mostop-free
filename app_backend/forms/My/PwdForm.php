<?php

namespace app_backend\forms\My;

use Yii;
use yii\base\Model;

use common\helpers\Common;
use common\helpers\Validator;

class PwdForm extends Model
{
    public $old_password;
    public $password;
    public $check_password;

    private $_sub_user_data = null;

    public function rules()
    {
        return [
            [['old_password', 'password', 'check_password'], 'required'],
            ['check_password', 'compare', 'compareAttribute' => 'password'],
            ['old_password', 'validateOldPassword'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'old_password' => '原密码',
            'password' => '新密码',
            'check_password' => '确认新密码',
        ];
    }

    public function validateOldPassword($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            if(Validator::password($this->old_password))
            {
                $sub_user_data = $this->getSubUserData();
                if(Common::createPassword($this->old_password, $sub_user_data['salt']) != $sub_user_data['password'])
                {
                    $this->addError($attribute, '原密码错误');
                }
            } else {
                $this->addError($attribute, Validator::$error);
            }
        }
    }

    public function validatePassword($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            if(Validator::password($this->password))
            {
                if($this->password == $this->old_password)
                {
                    $this->addError($attribute, '新密码不能和原密码相同');
                }
            } else {
                $this->addError($attribute, Validator::$error);
            }
        }
    }

    public function save()
    {
        if($this->validate())
        {
            $sub_user_data = $this->getSubUserData();
            $new_password = Common::createPassword($this->password, $sub_user_data['salt']);

            Yii::$app->db->createCommand()->update($sub_user_data['table_name'], ['password' => $new_password], 'userid = ' . $sub_user_data['userid'])->execute();

            return true;
        }
        return false;
    }

    private function getSubUserData()
    {
        if(!$this->_sub_user_data)
        {
            $user_id = Yii::$app->user->id;
            $sub_user_table_name = Common::subTable(Yii::$app->user->identity->username);
            $this->_sub_user_data = Yii::$app->db->createCommand("SELECT * FROM `{$sub_user_table_name}` WHERE `userid` = '{$user_id}'")->queryOne();
            $this->_sub_user_data && $this->_sub_user_data['table_name'] = $sub_user_table_name;
        }

        return $this->_sub_user_data;
    }
}