<?php

namespace app_backend\helpers;

use Yii;
use yii\helpers\Html;

use common\helpers\Common;

use app_backend\models\MenuExtends;

class BackendHelpers
{
    /**
     * 获取管理员菜单数据
     * @return array
     */
    public static function getAdminMenuDatas()
    {
        $menu_cache_datas = Yii::$app->mcache->get('menu_datas');
        $parent_datas = [];
        foreach($menu_cache_datas as $menu_cache_data)
        {
            if($menu_cache_data['enabled'] == 1 && $menu_cache_data['is_show'] == 1)
            {
                $parent_datas[$menu_cache_data['parent_id']][] = $menu_cache_data;
            }
        }

        $admin_menu_datas = [];
        $admin_menu_datas['top'] = isset($parent_datas[0]) ? $parent_datas[0] : [];
        $admin_menu_datas['left'] = [];
        foreach($admin_menu_datas['top'] as $data)
        {
            isset($parent_datas[$data['menuid']]) && $admin_menu_datas['left'] = array_merge($admin_menu_datas['left'], $parent_datas[$data['menuid']]);
        }
        foreach($admin_menu_datas['left'] as $k => $data)
        {
            !isset($admin_menu_datas['left'][$k]['sub_menu']) && $admin_menu_datas['left'][$k]['sub_menu'] = [];
            isset($parent_datas[$data['menuid']]) && $admin_menu_datas['left'][$k]['sub_menu'] = array_merge($admin_menu_datas['left'][$k]['sub_menu'], $parent_datas[$data['menuid']]);
        }

        return $admin_menu_datas;
    }

    /**
     * 按菜单级别返回所需的一维数组
     * @return array
     */
    public static function getMenuLevelDatas()
    {
        $menu_cache_datas = Yii::$app->mcache->get('menu_datas');

        $level_datas = [];
        foreach($menu_cache_datas as $menu_cache_data)
        {
            $data = [
                'menuid' => Html::encode($menu_cache_data['menuid']),
                'parent_id' => Html::encode($menu_cache_data['parent_id']),
                'level' => Html::encode($menu_cache_data['level']),
                'name' => Html::encode($menu_cache_data['name']),
                'controller' => Html::encode($menu_cache_data['controller']),
                'action' => Html::encode($menu_cache_data['action']),
                'enabled' => Html::encode($menu_cache_data['enabled']),
                'enabled_desc' => Html::encode(MenuExtends::$enabled[$menu_cache_data['enabled']]),
                'is_show' => Html::encode($menu_cache_data['is_show']),
                'is_show_desc' => Html::encode(MenuExtends::$is_show[$menu_cache_data['is_show']]),
                'sort' => Html::encode($menu_cache_data['sort']),
            ];
            $level_datas[] = $data;
        }

        return $level_datas;
    }

    /**
     * 获得指定菜单的所有父类菜单组及当前菜单组或下一级菜单组（3 级以内），返回多维数组
     * @param $menuid
     * @param bool $has_next
     * @return array
     */
    public static function getParentsAndSelfMenu($menuid, $has_next = false)
    {
        $menu_cache_datas = Yii::$app->mcache->get('menu_datas');

        $parent_datas = [];
        foreach($menu_cache_datas as $menu_cache_data)
        {
            $parent_datas[$menu_cache_data['parent_id']][] = $menu_cache_data;
        }

        if($menuid)
        {
            $menu_data = $menu_cache_datas[$menuid];
            $datas = $has_next ? (isset($parent_datas[$menuid]) ? [$parent_datas[$menuid]] : [[]]) : [];
            self::getParentsData($menu_data, $parent_datas, $menu_cache_datas, 'menuid', $datas);
            if(count($datas) > 3)
            {
                $datas = array_slice($datas, 0, 3);
            }
            return $datas;
        } else {
            return [$parent_datas ? $parent_datas[0] : $parent_datas];
        }
    }

    private static function getParentsData($data, $parent_datas, $datas, $fieldid_name, &$new_datas)
    {
        $parent_sub_datas = $parent_datas[$data['parent_id']];
        foreach($parent_sub_datas as $k => $parent_sub_data)
        {
            $parent_sub_data['selected'] = $parent_sub_data[$fieldid_name] == $data[$fieldid_name] ? true : false;
            $parent_sub_datas[$k] = $parent_sub_data;
        }
        array_unshift($new_datas, $parent_sub_datas);
        if(isset($datas[$data['parent_id']]))
        {
            self::getParentsData($datas[$data['parent_id']], $parent_datas, $datas, $fieldid_name, $new_datas);
        }
    }

    /**
     * 获取所有父级分类 ID 和所有子级分类 ID
     * @param $cache_name
     * @param $id_name
     * @param $id
     * @return array
     */
    public static function getParentIdsAndChildIds($cache_name, $id_name, $id)
    {
        $cache_datas = Yii::$app->mcache->get($cache_name);

        $parent_ids = [];
        self::getParentId($cache_datas[$id], $cache_datas, $parent_ids);

        $child_ids = [];
        self::getChildId($id_name, $cache_datas[$id], $cache_datas, $child_ids);

        return ['parent_ids' => implode(',', $parent_ids), 'child_ids' => implode(',', $child_ids)];
    }

    private static function getParentId($cache_data, $cache_datas, &$parent_ids)
    {
        if(isset($cache_datas[$cache_data['parent_id']]))
        {
            $parent_ids[] = $cache_data['parent_id'];
            self::getParentId($cache_datas[$cache_data['parent_id']], $cache_datas, $parent_ids);
        }
    }

    private static function getChildId($id_name, $cache_data, $cache_datas, &$child_ids)
    {
        foreach($cache_datas as $tmp_cache_data)
        {
            if($tmp_cache_data['parent_id'] == $cache_data[$id_name])
            {
                $child_ids[] = $tmp_cache_data[$id_name];
                self::getChildId($id_name, $tmp_cache_data, $cache_datas, $child_ids);
            }
        }
    }
}