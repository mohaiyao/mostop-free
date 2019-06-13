<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admin_login_log}}".
 *
 * @property int $logid 日志 ID
 * @property int $userid 用户 ID
 * @property string $ip IP
 * @property int $succeed 成功， 0 = 否，1 = 是
 * @property int $created_at 创建时间
 */
class AdminLoginLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_login_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'ip'], 'required'],
            [['userid', 'succeed', 'created_at'], 'integer'],
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
            'userid' => '用户 ID',
            'ip' => 'IP',
            'succeed' => '成功， 0 = 否，1 = 是',
            'created_at' => '创建时间',
        ];
    }
}
