<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property int $userid 用户 ID
 * @property string $name 姓名
 * @property int $sex 性别，0 = 女，1 = 男
 * @property string $birthday 生日
 * @property string $avatar 头像
 * @property string $mobile 手机
 * @property string $email 邮箱
 * @property string $qq QQ
 * @property string $weixin 微信
 * @property int $disabled 禁用，0 = 否，1 = 是
 * @property int $created_at 创建时间
 * @property int $created_by 创建来源用户 ID
 * @property int $updated_at 更新时间
 * @property int $updated_by 更新来源用户 ID
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid'], 'required'],
            [['userid', 'sex', 'disabled', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['birthday'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['avatar', 'email'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 11],
            [['qq', 'weixin'], 'string', 'max' => 15],
            [['userid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userid' => '用户 ID',
            'name' => '姓名',
            'sex' => '性别，0 = 女，1 = 男',
            'birthday' => '生日',
            'avatar' => '头像',
            'mobile' => '手机',
            'email' => '邮箱',
            'qq' => 'QQ',
            'weixin' => '微信',
            'disabled' => '禁用，0 = 否，1 = 是',
            'created_at' => '创建时间',
            'created_by' => '创建来源用户 ID',
            'updated_at' => '更新时间',
            'updated_by' => '更新来源用户 ID',
        ];
    }
}
