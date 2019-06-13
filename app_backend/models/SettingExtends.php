<?php

namespace app_backend\models;

use Yii;

use common\models\Setting;

class SettingExtends extends Setting
{
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete('setting_datas');
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Yii::$app->cache->delete('setting_datas');
    }
}