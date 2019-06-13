<?php

namespace app_backend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\helpers\Common;

use app_backend\helpers\BackendHelpers;

use app_backend\models\AdminLoginLogExtends;

use app_backend\forms\Site\LoginForm;

class SiteController extends MosController
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
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['error', 'captcha'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x009688,
                'height' => 36,
                'width' => 98,
                'maxLength' => 6,
                'minLength' => 6,
                'offset' => 2,
            ],
        ];
    }

    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $LoginForm = new LoginForm();
        if($LoginForm->load(Yii::$app->request->post()))
        {
            if($LoginForm->login())
            {
                return Common::echoJson(1000, '登录成功');
            } else {
                return Common::echoJson(1001, implode('<br>', $LoginForm->getFirstErrors()));
            }
        }

        $this->layout = false;
        return $this->render('login', [
            'title' => '登录',
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionIndex()
    {
        $this->layout = false;

        $admin_data = Yii::$app->mcache->getByKey('admin_datas', Yii::$app->user->id);
        $admin_menu_datas = BackendHelpers::getAdminMenuDatas();

        return $this->render('index', [
            'title' => '首页',
            'admin_data' => $admin_data,
            'admin_menu_datas' => $admin_menu_datas,
        ]);
    }

    public function actionHome()
    {
        $admin_data = Yii::$app->mcache->getByKey('admin_datas', Yii::$app->user->id);

        $last_login_log_data = AdminLoginLogExtends::find()->where(['userid' => Yii::$app->user->id, 'succeed' => 1])->orderBy(['created_at' => SORT_DESC, 'logid' => SORT_DESC])->offset(1)->limit(1)->asArray()->one();
        $last_login_log_data && $last_login_log_data['created_at_desc'] = Common::dateFormat($last_login_log_data['created_at']);

        $admin_login_log_count = AdminLoginLogExtends::find()->where(['userid' => Yii::$app->user->id, 'succeed' => 1])->count();

        $system_info =
        [
            'yii_version' => Yii::getVersion(),
            'os' => PHP_OS,
            'web_server' => strpos($_SERVER['SERVER_SOFTWARE'], 'PHP') === false ? $_SERVER['SERVER_SOFTWARE'] .' PHP/' . phpversion() : $_SERVER['SERVER_SOFTWARE'],
            'mysql_version' => Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION),
            'file_upload_max_size' => @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknown',
            'time' => Common::dateFormat(time()),
        ];

        return $this->render('home', [
            'title' => '后台首页',
            'admin_data' => $admin_data,
            'last_login_log_data' => $last_login_log_data,
            'admin_login_log_count' => $admin_login_log_count,
            'system_info' => $system_info,
        ]);
    }
}