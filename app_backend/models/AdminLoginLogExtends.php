<?php

namespace app_backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

use common\models\AdminLoginLog;

class AdminLoginLogExtends extends AdminLoginLog
{
    public static $succeed = [1 => '成功', 0 => '失败'];

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }
}