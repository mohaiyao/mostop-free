<?php

namespace app_backend\controllers;

use Yii;

use common\helpers\Common;

use app_backend\models\AdminExtends;

use app_backend\forms\My\InfoForm;
use app_backend\forms\My\PwdForm;

class MyController extends MosController
{
    public function actionInfo()
    {
        $InfoForm = new InfoForm();
        if($InfoForm->load(Yii::$app->request->post()))
        {
            if($InfoForm->save())
            {
                return Common::echoJson(1000, '保存成功');
            } else {
                return Common::echoJson(1001, implode('<br>', $InfoForm->getFirstErrors()));
            }
        }

        $admin_data = Yii::$app->mcache->getByKey('admin_datas', Yii::$app->user->id);

        return $this->render('info', [
            'title' => '个人资料',
            'admin_data' => $admin_data,
            'sex_k_v' => AdminExtends::$sex,
        ]);
    }

    public function actionPwd()
    {
        $PwdForm = new PwdForm();
        if($PwdForm->load(Yii::$app->request->post()))
        {
            if($PwdForm->save())
            {
                return Common::echoJson(1000, '保存成功');
            } else {
                return Common::echoJson(1001, implode('<br>', $PwdForm->getFirstErrors()));
            }
        }

        return $this->render('pwd', [
            'title' => '修改密码'
        ]);
    }
}