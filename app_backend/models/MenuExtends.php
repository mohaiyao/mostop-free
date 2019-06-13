<?php

namespace app_backend\models;

use Yii;

use common\models\Menu;

use app_backend\helpers\BackendHelpers;

class MenuExtends extends Menu
{
    public static $enabled = [1 => '启用', 0 => '禁用'];
    public static $is_show = [1 => '是', 0 => '否'];

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete('menu_datas');
        Yii::$app->cache->delete('menu_ca_datas');
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Yii::$app->cache->delete('menu_datas');
        Yii::$app->cache->delete('menu_ca_datas');
    }

    /**
     * 删除菜单及子菜单
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteRelationAll()
    {
        if($this->delete())
        {
            $child_ids = $this->child_ids ? explode(',', $this->child_ids) : [];
            $child_ids && self::deleteAll(['in', 'menuid', $child_ids]);

            $parent_ids = $this->parent_ids ? explode(',', $this->parent_ids) : [];
            foreach($parent_ids as $parent_id)
            {
                $ParentCategory = self::find()->where(['menuid' => $parent_id])->one();
                $parent_get_ids = BackendHelpers::getParentIdsAndChildIds('menu_datas', 'menuid', $parent_id);
                $ParentCategory->parent_ids = $parent_get_ids['parent_ids'];
                $ParentCategory->child_ids = $parent_get_ids['child_ids'];
                $ParentCategory->save();
            }

            return true;
        }
        return false;
    }
}