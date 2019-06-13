<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Html;

class UploadForm extends Model
{
    public $image_file;

    public $allow_file_dir = ['avatar'];

    public function rules()
    {
        return [
            [['image_file'], 'file', 'extensions' => 'jpg, png, gif, bmp, jpeg'],
        ];
    }

    /**
     * 单文件上传
     * @param $file_field
     * @param $file_dir
     * @param $has_upload_dir
     * @return array|bool
     * @throws \yii\base\Exception
     */
    public function upload($file_field, $file_dir, $has_upload_dir)
    {
        if($this->validate())
        {
            $psn_path_dir = Yii::getAlias('@app_backend') . '/web';

            $filepath = ($has_upload_dir ? '/uploads/' : '/') . ($file_dir ? $file_dir . '/' : '') . date('Ym') . '/' . date('d') . '/';
            $filename = time() . mt_rand(10000, 99999) . '.' . $this->{$file_field}->extension;

            $upload_dir = $psn_path_dir . $filepath;
            FileHelper::createDirectory($upload_dir);

            $upload_file = $upload_dir . $filename;
            if($this->{$file_field}->saveAs($upload_file))
            {
                $result = [
                    'url' => Html::encode($filepath . $filename),
                    'alias' => Html::encode($this->{$file_field}->name),
                    'filesize' => Html::encode($this->{$file_field}->size),
                    'filetype' => Html::encode($this->{$file_field}->type),
                    'fileext' => Html::encode($this->{$file_field}->extension),
                ];

                return $result;
            }
        }
        return false;
    }
}