<?php

namespace app_backend\forms\Site;

use Yii;
use yii\base\Model;

use common\helpers\Common;
use common\helpers\Validator;

use common\models\UserIdentity;

use app_backend\models\AdminExtends;
use app_backend\models\AdminLoginLogExtends;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $verify_code;

    private $user_identity = null;

    public function rules()
    {
        return [
            [['username', 'password', 'verify_code'], 'required'],
            ['verify_code', 'captcha'],
            ['username', 'validateUsername'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'verify_code' => '验证码',
        ];
    }

    public function validateUsername($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            if(!Validator::username($this->username))
            {
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
                $user_identity = $this->getUserIdentity();
                if($user_identity)
                {
                    $sub_user_table_name = Common::subTable($user_identity->username);
                    $sub_user_data = Yii::$app->db->createCommand("SELECT * FROM `{$sub_user_table_name}` WHERE `userid` = '{$user_identity->userid}'")->queryOne();
                    if(Common::createPassword($this->password, $sub_user_data['salt']) == $sub_user_data['password'])
                    {
                        $Admin = AdminExtends::findOne($user_identity->userid);
                        if($Admin)
                        {
                            if($Admin->disabled)
                            {
                                $this->addError($attribute, '该管理账户禁用后台');
                            }
                        } else {
                            $this->addError($attribute, '该管理账户无后台权限');
                        }
                    } else {
                        $this->addError($attribute, '用户名或密码错误');
                    }
                } else {
                    $this->addError($attribute, '用户名或密码错误');
                }
            } else {
                $this->addError($attribute, Validator::$error);
            }
        }
    }

    public function login()
    {
        if($this->validate())
        {
            $user_identity = $this->getUserIdentity();
            $result = Yii::$app->user->login($user_identity);
            $AdminLoginLog = new AdminLoginLogExtends();
            $data['AdminLoginLogExtends'] = [
                'userid'  => $user_identity->userid,
                'ip'      => isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : Yii::$app->request->getUserIP(),
            ];
            if($result)
            {
                $data['AdminLoginLogExtends']['succeed'] = 1;
            } else {
                $data['AdminLoginLogExtends']['succeed'] = 0;
                $this->addError('password', '登录失败');
            }
            $AdminLoginLog->load($data) && $AdminLoginLog->save();
            return $result;
        } else {
            if($this->user_identity)
            {
                $AdminLoginLog = new AdminLoginLogExtends();
                $data['AdminLoginLogExtends'] = [
                    'userid' => $this->user_identity->userid,
                    'ip' => isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : Yii::$app->request->getUserIP(),
                    'succeed' => 0,
                ];
                $AdminLoginLog->load($data) && $AdminLoginLog->save();
            }
            return false;
        }
    }

    public function getUserIdentity()
    {
        if($this->user_identity === null)
        {
            $this->user_identity = UserIdentity::findOne(['username' => strtolower($this->username)]);
        }

        return $this->user_identity;
    }
}