<?php

namespace app_backend\controllers;

use Yii;

use common\helpers\Common;

use app_backend\forms\Setting\SettingForm;

class SettingController extends MosController
{
    public function actionSafe()
    {
        $SettingForm = new SettingForm();
        $SettingForm->setScenario('safe');
        if($SettingForm->load(Yii::$app->request->post()))
        {
            if($SettingForm->save())
            {
                return Common::echoJson(1000, '保存成功');
            } else {
                return Common::echoJson(1001, implode('<br>', $SettingForm->getFirstErrors()));
            }
        }

        return $this->render('safe', [
            'title' => '安全设置',
        ]);
    }

    public function actionCache()
    {
        $SettingForm = new SettingForm();
        $SettingForm->setScenario('cache');
        if($SettingForm->load(Yii::$app->request->post()))
        {
            if($SettingForm->save())
            {
                return Common::echoJson(1000, '保存成功');
            } else {
                return Common::echoJson(1001, implode('<br>', $SettingForm->getFirstErrors()));
            }
        }

        return $this->render('cache', [
            'title' => '缓存设置',
        ]);
    }
}