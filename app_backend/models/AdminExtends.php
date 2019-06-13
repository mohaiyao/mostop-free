<?php

namespace app_backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;

use common\models\Admin;

class AdminExtends extends Admin
{
    public static $sex = [1 => '男', 0 => '女'];
    public static $disabled = [0 => '启用', 1 => '禁用'];

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
                'value' => function ($event){
                    return Yii::$app->user->id;
                },
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete('admin_datas');
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Yii::$app->cache->delete('admin_datas');
    }

    public function getUser()
    {
        return $this->hasOne(UserExtends::className(), ['userid' => 'userid'])->asArray();
    }

    /**
     * 删除管理员表及管理员相关表的数据
     * @return bool
     */
    public function deleteRelationAll()
    {
        $this->disabled = 1;
        return $this->save();
    }
}