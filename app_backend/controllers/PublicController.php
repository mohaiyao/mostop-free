<?php

namespace app_backend\controllers;

use Yii;
use yii\web\UploadedFile;

use common\helpers\Common;
use common\forms\UploadForm;

class PublicController extends MosController
{
    public function actionUpload()
    {
        if(Yii::$app->request->isPost)
        {
            $file_field = Yii::$app->request->post('file_field');
            $file_dir = Yii::$app->request->post('file_dir');
            $has_upload_dir = Yii::$app->request->post('no_upload_dir') ? false : true;

            $UploadForm = new UploadForm();
            if(!property_exists($UploadForm, $file_field))
            {
                return Common::echoJson(1002, '不允许的文件字段');
            }
            if($file_dir && !in_array($file_dir, $UploadForm->allow_file_dir))
            {
                return Common::echoJson(1003, '不允许的文件目录');
            }
            $UploadForm->{$file_field} = UploadedFile::getInstance($UploadForm, $file_field);
            if($result = $UploadForm->upload($file_field, $file_dir, $has_upload_dir))
            {
                return Common::echoJson(1000, '上传成功', $result);
            } else {
                return Common::echoJson(1004, implode('<br>', $UploadForm->getFirstErrors()));
            }
        }

        return Common::echoJson(1001, '请求有误');
    }
}