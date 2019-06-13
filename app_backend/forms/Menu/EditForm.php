<?php

namespace app_backend\forms\Menu;

use Yii;
use yii\base\Model;

use app_backend\helpers\BackendHelpers;

use app_backend\models\MenuExtends;

class EditForm extends Model
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
            [['name', 'enabled'], 'required'],
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
            'enabled' => '状态',
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

    public function save($menuid)
    {
        if($this->validate())
        {
            $Menu = MenuExtends::findOne($menuid);

            $old_parent_id = $Menu->parent_id;

            $Menu->parent_id = $this->parent_id;
            $Menu->name = $this->name;
            $Menu->controller = $this->controller;
            $Menu->action = $this->action;
            $Menu->enabled = $this->enabled;
            $Menu->sort = $this->sort;
            $Menu->is_show = $this->is_show;

            if($Menu->save())
            {
                if(!$Menu->enabled)
                {
                    $child_ids = $Menu->child_ids ? explode(',', $Menu->child_ids) : [];
                    $child_ids && MenuExtends::updateAll(['enabled' => $Menu->enabled], ['in', 'menuid', $child_ids]);
                }

                if($old_parent_id != $this->parent_id)
                {
                    $old_parent_ids = $Menu->parent_ids ? explode(',', $Menu->parent_ids) : [];
                    foreach($old_parent_ids as $old_parent_id)
                    {
                        $OldParentCategory = MenuExtends::find()->where(['menuid' => $old_parent_id])->one();
                        $old_parent_get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $old_parent_id);
                        $OldParentCategory->parent_ids = $old_parent_get_ids['parent_ids'];
                        $OldParentCategory->child_ids = $old_parent_get_ids['child_ids'];
                        $OldParentCategory->save();
                    }

                    $old_child_ids = $Menu->child_ids ? explode(',', $Menu->child_ids) : [];
                    foreach($old_child_ids as $old_child_id)
                    {
                        $OldChildCategory = MenuExtends::find()->where(['menuid' => $old_child_id])->one();
                        $old_child_get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $old_child_id);
                        $OldChildCategory->parent_ids = $old_child_get_ids['parent_ids'];
                        $OldChildCategory->child_ids = $old_child_get_ids['child_ids'];
                        $OldChildCategory->save();
                    }

                    $get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $Menu->menuid);
                    $Menu->parent_ids = $get_ids['parent_ids'];
                    $Menu->child_ids = $get_ids['child_ids'];
                    if($Menu->save())
                    {
                        $parent_ids = $get_ids['parent_ids'] ? explode(',', $get_ids['parent_ids']) : [];
                        foreach($parent_ids as $parent_id)
                        {
                            $ParentCategory = MenuExtends::find()->where(['menuid' => $parent_id])->one();
                            $parent_get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $parent_id);
                            $ParentCategory->parent_ids = $parent_get_ids['parent_ids'];
                            $ParentCategory->child_ids = $parent_get_ids['child_ids'];
                            $ParentCategory->save();
                        }

                        $child_ids = $get_ids['child_ids'] ? explode(',', $get_ids['child_ids']) : [];
                        foreach($child_ids as $child_id)
                        {
                            $ChildCategory = MenuExtends::find()->where(['menuid' => $child_id])->one();
                            $child_get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $child_id);
                            $ChildCategory->parent_ids = $child_get_ids['parent_ids'];
                            $ChildCategory->child_ids = $child_get_ids['child_ids'];
                            $ChildCategory->save();
                        }
                    }
                }

                return true;
            }
        }
        return false;
    }
}