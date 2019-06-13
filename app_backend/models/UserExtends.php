<?php

namespace app_backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

use common\models\User;

class UserExtends extends User
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}