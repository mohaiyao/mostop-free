<?php

namespace app_backend\components;

use Yii;

use common\helpers\Common;
use common\components\MosCache;

use app_backend\models\MenuExtends;
use app_backend\models\AdminExtends;

class MCache extends MosCache
{
    public function menu_datas($var = [])
    {
        $value = [];

        $datas = MenuExtends::find()->orderBy(['sort' => SORT_ASC])->asArray()->all();

        $parent_datas = [];
        foreach($datas as $data)
        {
            $parent_datas[$data['parent_id']][] = $data;
        }
        $parent_datas && $this->getLevelData('menuid', $parent_datas[0], 0, $parent_datas, $value);

        return $value;
    }

    public function menu_ca_datas($var = [])
    {
        $value = [];

        $level_datas = Yii::$app->mcache->get('menu_datas');
        foreach($level_datas as $level_data)
        {
            $level_data['controller'] && $level_data['action'] && $value[$level_data['controller'] . '/' . $level_data['action']] = $level_data;
        }

        return $value;
    }

    private function getLevelData($id_name, $source_datas, $level, $parent_datas, &$level_datas)
    {
        foreach($source_datas as $data)
        {
            $data['level'] = $level;
            $data['has_sub'] = isset($parent_datas[$data[$id_name]]) ? true : false;
            $level_datas[$data[$id_name]] = $data;
            if(isset($parent_datas[$data[$id_name]]))
            {
                $this->getLevelData($id_name, $parent_datas[$data[$id_name]], $level + 1, $parent_datas, $level_datas);
            }
        }
    }

    public function admin_datas($var = [])
    {
        $value = [];

        $datas = AdminExtends::find()->with('user')->asArray()->all();
        foreach($datas as $data)
        {
            $value[$data['userid']] = $data;
        }

        return $value;
    }
}