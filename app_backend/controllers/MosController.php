<?php

namespace app_backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use common\helpers\Common;

use app_backend\models\AdminOperateLogExtends;

class MosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        // 控制器方法
        $controller_action = $action->controller->id . '/' . $action->id;

        if(!parent::beforeAction($action))
        {
            return false;
        }

        // 站点配置
        Yii::$app->params['setting_datas'] = Yii::$app->mcache->get('setting_datas');

        // 视图参数配置
        $this->view->params = array_merge($this->view->params, Yii::$app->params['view_params']);

        // 操作日志
        $operate_not_record = ['site/login', 'site/captcha', 'site/index', 'site/home', 'tool/operate-log'];
        if(!in_array($controller_action, $operate_not_record))
        {
            $enable_operate_log = Yii::$app->mcache->getByKey('setting_datas', 'backend_enable_operate_log');
            if($enable_operate_log)
            {
                $AdminOperateLog = new AdminOperateLogExtends();
                $data['AdminOperateLogExtends'] = [
                    'url'    => $_SERVER['REQUEST_URI'],
                    'userid' => Yii::$app->user->id,
                    'ip'     => isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : Yii::$app->request->getUserIP(),
                ];
                $AdminOperateLog->load($data) && $AdminOperateLog->save();
            }
        }

        // 禁止删除操作
        $delete_not_action = ['permission/admin-del', 'menu/del'];
        if(in_array($controller_action, $delete_not_action))
        {
            $enable_delete_action = Yii::$app->mcache->getByKey('setting_datas', 'backend_enable_delete_action');
            if(!$enable_delete_action)
            {
                exit(Common::echoJson(1099, "删除操作禁止执行，请在《设置 > 安全设置》中启用"));
            }
        }

        // 文件上传操作
        $upload_not_action = ['public/upload'];
        if(in_array($controller_action, $upload_not_action))
        {
            $enable_upload_file = Yii::$app->mcache->getByKey('setting_datas', 'backend_enable_upload_file');
            if(!$enable_upload_file)
            {
                exit(Common::echoJson(1099, "文件上传禁止执行，请在《设置 > 安全设置》中启用"));
            }
        }
        
        return true;
    }
}