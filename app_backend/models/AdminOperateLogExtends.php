<?php

namespace app_backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

use common\models\AdminOperateLog;

class AdminOperateLogExtends extends AdminOperateLog
{
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