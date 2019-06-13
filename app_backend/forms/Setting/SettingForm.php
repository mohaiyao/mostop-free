<?php

namespace app_backend\forms\Setting;

use yii\base\Model;

use app_backend\models\SettingExtends;

class SettingForm extends Model
{
    public $backend_enable_operate_log;
    public $backend_enable_delete_action;
    public $backend_enable_upload_file;

    public $system_cache_time;

    public function rules()
    {
        return [
            [['backend_enable_operate_log', 'backend_enable_delete_action', 'backend_enable_upload_file'], 'safe', 'on' => 'safe'],
            [['system_cache_time'], 'required', 'on' => 'cache'],
            [['system_cache_time'], 'integer', 'on' => 'cache'],
            ['system_cache_time', 'validateSystemCacheTime', 'on' => 'cache'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'backend_enable_operate_log' => '启用后台操作日志',
            'backend_enable_delete_action' => '启用后台删除操作',
            'backend_enable_upload_file' => '启用后台文件上传',
            'system_cache_time' => '缓存时间',
        ];
    }

    public function validateSystemCacheTime($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            if($this->system_cache_time < 0)
            {
                $this->addError($attribute, '缓存时间不能小于 0');
            }
        }
    }

    public function save()
    {
        if($this->validate())
        {
            foreach($this->activeAttributes() as $attribute)
            {
                $attr_array = explode('_', $attribute);
                $app = $attr_array[0];
                $parameter = str_replace($app . '_', '', $attribute);
                $Setting = SettingExtends::find()->where(['app' => $app, 'parameter' => $parameter])->one();
                if($Setting)
                {
                    $Setting->value = $this->attributes[$attribute];
                    $Setting->save();
                } else {
                    $Setting = new SettingExtends();
                    $data['Setting'] = [
                        'app' => $app,
                        'parameter' => $parameter,
                        'value' => $this->attributes[$attribute],
                    ];
                    $Setting->load($data) && $Setting->save();
                }
            }
            return true;
        }
        return false;
    }
}