<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admin_operate_log}}".
 *
 * @property int $logid 日志 ID
 * @property string $url 链接地址
 * @property int $userid 用户 ID
 * @property string $ip IP
 * @property int $created_at 创建时间
 */
class AdminOperateLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_operate_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'userid', 'ip'], 'required'],
            [['url'], 'string'],
            [['userid', 'created_at'], 'integer'],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'logid' => '日志 ID',
            'url' => '链接地址',
            'userid' => '用户 ID',
            'ip' => 'IP',
            'created_at' => '创建时间',
        ];
    }
}
