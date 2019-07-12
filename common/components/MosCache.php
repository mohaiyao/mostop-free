<?php

namespace common\components;

use Yii;

use common\models\Setting;

class MosCache extends MosTopCache
{
    /**
     * 获取数据库数据缓存
     * @param $keys
     * @param null $duration
     * @param null $dependency
     * @return mixed
     */
    public function get($keys, $duration = null, $dependency = null)
    {
        if(is_array($keys))
        {
            $key = $keys[0];
            $var = $keys;
            unset($var[0]);
        } else {
            $key = $keys;
            $var = [];
        }
        if(!$duration)
        {
            $duration = 24 * 60 * 60;
            if($key != 'setting_datas')
            {
                $setting_datas = $this->get('setting_datas', $duration, $dependency);
                $setting_datas && $duration = $setting_datas['system_cache_time'];
            }
        }
        $value = Yii::$app->cache->getOrSet($keys, function () use ($key, $var){
            return $this->getData($key, $var);
        }, $duration, $dependency);

        return $value;
    }

    /**
     * 获取数据
     * @param $key
     * @param array $var
     * @return array
     */
    protected function getData($key, $var = [])
    {
        return method_exists($this, $key) ? $this->{$key}($var) : [];
    }

    /**
     * 设置数据库数据缓存
     * @param $key
     * @param array $var
     * @param null $duration
     * @param null $dependency
     * @return bool
     */
    public function set($key, $var = [], $duration = null, $dependency = null)
    {
        if(!$duration)
        {
            $duration = 24 * 60 * 60;
            if($key != 'setting_datas')
            {
                $setting_datas = $this->get('setting_datas', $duration, $dependency);
                $setting_datas && $duration = $setting_datas['system_cache_time'];
            }
        }

        $data = $this->getData($key, $var);

        return Yii::$app->cache->set($key, $data, $duration, $dependency);
    }

    /**
     * 根据 ID 值获取对应缓存数据
     * @param $key
     * @param $id
     * @param null $duration
     * @param null $dependency
     * @return array
     */
    public function getByKey($key, $id, $duration = null, $dependency = null)
    {
        $datas = $this->get($key, $duration, $dependency);
        return isset($datas[$id]) ? $datas[$id] : [];
    }

    /**
     * 全局配置
     * @param array $var
     * @return array
     */
    public function setting_datas($var = [])
    {
        $value = [];

        $datas = Setting::find()->asArray()->all();
        foreach($datas as $data)
        {
            $value[$data['app'] . '_' . $data['parameter']] = $data['value'];
        }

        return $value;
    }
}