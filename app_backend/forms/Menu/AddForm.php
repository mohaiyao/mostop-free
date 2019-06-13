<?php

namespace app_backend\forms\Menu;

use Yii;
use yii\base\Model;

use app_backend\helpers\BackendHelpers;

use app_backend\models\MenuExtends;

class AddForm extends Model
{
    public $parent_id;
    public $name;
    public $controller;
    public $action;
    public $enabled;
    public $sort;
    public $is_show;

    public function rules()
    {
        return [
            [['parent_id', 'enabled', 'is_show', 'sort'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['controller', 'action'], 'string', 'max' => 30],
            ['sort', 'validateSort'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'parent_id' => '父级 ID',
            'name' => '菜单名',
            'controller' => '控制器',
            'action' => '方法',
            'enabled' => '是否启用',
            'is_show' => '是否显示',
            'sort' => '排序',
        ];
    }

    public function validateSort($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            if($this->sort < 0)
            {
                $this->addError($attribute, '排序不能小于 0');
            }
        }
    }

    public function save()
    {
        if($this->validate())
        {
            $Menu = new MenuExtends();
            $data['MenuExtends'] = [
                'parent_id' => $this->parent_id,
                'name' => $this->name,
                'controller' => $this->controller,
                'action' => $this->action,
                'enabled' => $this->enabled,
                'sort' => $this->sort,
                'is_show' => $this->is_show,
            ];
            if($Menu->load($data) && $Menu->save())
            {
                $get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $Menu->menuid);
                $Menu->parent_ids = $get_ids['parent_ids'];
                $Menu->child_ids = $get_ids['child_ids'];
                if($Menu->save())
                {
                    $parent_ids = $get_ids['parent_ids'] ? explode(',', $get_ids['parent_ids']) : [];
                    foreach($parent_ids as $parent_id)
                    {
                        $ParentMenu = MenuExtends::find()->where(['menuid' => $parent_id])->one();
                        $parent_get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $parent_id);
                        $ParentMenu->parent_ids = $parent_get_ids['parent_ids'];
                        $ParentMenu->child_ids = $parent_get_ids['child_ids'];
                        $ParentMenu->save();
                    }

                    $child_ids = $get_ids['child_ids'] ? explode(',', $get_ids['child_ids']) : [];
                    foreach($child_ids as $child_id)
                    {
                        $ChildMenu = MenuExtends::find()->where(['menuid' => $child_id])->one();
                        $child_get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $child_id);
                        $ChildMenu->parent_ids = $child_get_ids['parent_ids'];
                        $ChildMenu->child_ids = $child_get_ids['child_ids'];
                        $ChildMenu->save();
                    }
                }

                return true;
            }
        }
        return false;
    }
}