<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property int $menuid 菜单 ID
 * @property int $parent_id 父级 ID
 * @property string $parent_ids 所有父级 ID
 * @property string $child_ids 所有子级 ID
 * @property string $name 菜单名
 * @property string $controller 控制器
 * @property string $action 方法
 * @property int $enabled 是否启用，0 = 否，1 = 是
 * @property int $is_show 是否显示，1 = 是，0 = 否
 * @property int $sort 排序
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'enabled', 'is_show', 'sort'], 'integer'],
            [['child_ids'], 'string'],
            [['name'], 'required'],
            [['parent_ids'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 20],
            [['controller', 'action'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'menuid' => '菜单 ID',
            'parent_id' => '父级 ID',
            'parent_ids' => '所有父级 ID',
            'child_ids' => '所有子级 ID',
            'name' => '菜单名',
            'controller' => '控制器',
            'action' => '方法',
            'enabled' => '是否启用，0 = 否，1 = 是',
            'is_show' => '是否显示，1 = 是，0 = 否',
            'sort' => '排序',
        ];
    }
}
