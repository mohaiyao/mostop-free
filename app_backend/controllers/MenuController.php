<?php

namespace app_backend\controllers;

use Yii;
use yii\helpers\Html;

use common\helpers\Common;

use app_backend\helpers\BackendHelpers;

use app_backend\forms\Menu\AddForm;
use app_backend\forms\Menu\EditForm;

use app_backend\models\MenuExtends;

class MenuController extends MosController
{
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax)
        {
            $datas = BackendHelpers::getMenuLevelDatas();

            return Common::echoJson(1000, '', $datas);
        }

        return $this->render('index', [
            'title' => '菜单列表',
        ]);
    }

    public function actionAdd()
    {
        $AddForm = new AddForm();
        if($AddForm->load(Yii::$app->request->post()))
        {
            $parent_ids = array_filter($AddForm->parent_id);
            $AddForm->parent_id = $parent_ids ? $parent_ids[count($parent_ids) - 1] : 0;
            $parent_data = [];
            if($AddForm->parent_id > 0)
            {
                $parent_data = Yii::$app->mcache->getByKey('menu_datas', $AddForm->parent_id);
            }
            $AddForm->enabled = $parent_data ? $parent_data['enabled'] : 1;
            if(count($parent_ids) < 2)
            {
                $AddForm->controller = '';
                $AddForm->action = '';
            }
            if($AddForm->save())
            {
                return Common::echoJson(1000, '保存成功');
            } else {
                return Common::echoJson(1001, implode('<br>', $AddForm->getFirstErrors()));
            }
        }

        $menu_parents_datas = BackendHelpers::getParentsAndSelfMenu(Yii::$app->request->get('menuid'), true);

        return $this->render('add', [
            'title' => '添加菜单',
            'menu_parents_datas' => $menu_parents_datas,
            'is_show_k_v' => MenuExtends::$is_show,
        ]);
    }

    public function actionEdit()
    {
        $menuid = Yii::$app->request->get('menuid');

        $menu_data = Yii::$app->mcache->getByKey('menu_datas', $menuid);
        if(!$menu_data)
        {
            return Common::echoJson(1001, '请选择操作菜单');
        }

        $EditForm = new EditForm();
        if($EditForm->load(Yii::$app->request->post()))
        {
            $parent_ids = array_filter($EditForm->parent_id);
            $EditForm->parent_id = $parent_ids ? $parent_ids[count($parent_ids) - 1] : 0;
            $parent_data = Yii::$app->mcache->getByKey('menu_datas', $EditForm->parent_id);
            $EditForm->enabled = $parent_data && !$parent_data['enabled'] ? $parent_data['enabled'] : $EditForm->enabled;
            if(count($parent_ids) < 2)
            {
                $EditForm->controller = '';
                $EditForm->action = '';
            }
            if($EditForm->save($menuid))
            {
                return Common::echoJson(1000, '保存成功');
            } else {
                return Common::echoJson(1002, implode('<br>', $EditForm->getFirstErrors()));
            }
        }

        $menu_parents_datas = BackendHelpers::getParentsAndSelfMenu(Yii::$app->request->get('menuid'));

        $parent_menu_data = Yii::$app->mcache->getByKey('menu_datas', $menu_data['parent_id']);

        return $this->render('edit', [
            'title' => '编辑菜单',
            'menu_parents_datas' => $menu_parents_datas,
            'menu_data' => $menu_data,
            'parent_menu_data' => $parent_menu_data,
            'enabled_k_v' => MenuExtends::$enabled,
            'is_show_k_v' => MenuExtends::$is_show,
        ]);
    }

    public function actionDel()
    {
        $menuid = Yii::$app->request->get('menuid');

        $menu_data = Yii::$app->mcache->getByKey('menu_datas', $menuid);
        if(!$menu_data)
        {
            return Common::echoJson(1001, '请选择操作菜单');
        }

        $Menu = MenuExtends::findOne($menuid);
        if($Menu->deleteRelationAll())
        {
            return Common::echoJson(1000, '删除成功');
        } else {
            return Common::echoJson(1002, implode('<br>', $Menu->getFirstErrors()));
        }
    }

    public function actionGetSubMenuData()
    {
        $parent_id = Yii::$app->request->get('parent_id');
        $except_menuid = Yii::$app->request->get('except_menuid');

        $menu_cache_datas = Yii::$app->mcache->get('menu_datas');

        $sub_menu_datas = [];
        foreach($menu_cache_datas as $menu_cache_data)
        {
            if($menu_cache_data['parent_id'] == $parent_id && (!$except_menuid || $except_menuid != $menu_cache_data['menuid']))
            {
                $sub_menu_datas[] = [
                    'menuid' => Html::encode($menu_cache_data['menuid']),
                    'name' => Html::encode($menu_cache_data['name']),
                ];
            }
        }

        return Common::echoJson(1000, '', $sub_menu_datas);
    }

    public function actionRepair()
    {
        Yii::$app->cache->delete('menu_datas');
        Yii::$app->cache->delete('menu_ca_datas');
        $menu_datas = Yii::$app->mcache->get('menu_datas');
        foreach($menu_datas as $menu_data)
        {
            $ParentIdsAndChildIds = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $menu_data['menuid']);
            MenuExtends::updateAll(['parent_ids' => $ParentIdsAndChildIds['parent_ids'], 'child_ids' => $ParentIdsAndChildIds['child_ids']], ['menuid' => $menu_data['menuid']]);
        }

        return Common::echoJson(1000, '修复成功');
    }
}