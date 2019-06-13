<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property string $app 应用
 * @property string $parameter 参数名
 * @property string $value 参数值
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app', 'parameter'], 'required'],
            [['value'], 'string'],
            [['app'], 'string', 'max' => 15],
            [['parameter'], 'string', 'max' => 32],
            [['app', 'parameter'], 'unique', 'targetAttribute' => ['app', 'parameter']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'app' => '应用',
            'parameter' => '参数名',
            'value' => '参数值',
        ];
    }
}
