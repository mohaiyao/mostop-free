<?php

namespace app_backend\controllers;

use Yii;
use yii\helpers\Html;

use common\helpers\Common;

use app_backend\models\UserExtends;
use app_backend\models\AdminLoginLogExtends;
use app_backend\models\AdminOperateLogExtends;
use app_backend\models\LogExtends;

class ToolController extends MosController
{
    public function actionLoginLog()
    {
        // 分页输出
        if(Yii::$app->request->isAjax)
        {
            // 搜索条件
            $where = [];
            $and_where = ['and'];
            $search = Yii::$app->request->get('search');
            if($search)
            {
                if($search['username'])
                {
                    $user_data = UserExtends::find()->where(['username' => $search['username']])->asArray()->one();
                    $where['userid'] = $user_data ? $user_data['userid'] : 0;
                }
                $search['ip'] && $where['ip'] = $search['ip'];
                if($search['created_at'])
                {
                    $date_array = explode(' ~ ', $search['created_at']);
                    $and_where[] = ['>=', 'created_at', strtotime($date_array[0])];
                    $and_where[] = ['<=', 'created_at', strtotime($date_array[1])];
                }
            }

            // 分页信息
            $page = Yii::$app->request->get('page');
            $limit = Yii::$app->request->get('limit');
            $offset = ($page - 1) * $limit;
            $count = AdminLoginLogExtends::find()->where($where)->andWhere($and_where)->count();

            $admin_login_log_datas = AdminLoginLogExtends::find()->where($where)->andWhere($and_where)->orderBy(['created_at' => SORT_DESC, 'logid' => SORT_DESC])->offset($offset)->limit($limit)->asArray()->all();

            $echo_datas = [];
            if($admin_login_log_datas)
            {
                $userids = array_unique(array_column($admin_login_log_datas, 'userid'));
                $userid_username = [];
                foreach($userids as $userid)
                {
                    $admin_data = Yii::$app->mcache->getByKey('admin_datas', $userid);
                    $userid_username[$admin_data['userid']] = $admin_data['user']['username'];
                }
                foreach($admin_login_log_datas as $k => $admin_login_log_data)
                {
                    $echo_data = [
                        'logid' => Html::encode($admin_login_log_data['logid']),
                        'userid_desc' => Html::encode($userid_username[$admin_login_log_data['userid']]),
                        'ip' => Html::encode($admin_login_log_data['ip']),
                        'succeed' => Html::encode($admin_login_log_data['succeed']),
                        'succeed_desc' => Html::encode(AdminLoginLogExtends::$succeed[$admin_login_log_data['succeed']]),
                        'created_at_desc' => Html::encode(Common::dateFormat($admin_login_log_data['created_at'])),
                    ];

                    $echo_datas[] = $echo_data;
                }
            }

            return Common::echoJson(1000, '', $echo_datas, $count);
        }

        return $this->render('login_log', [
            'title' => '登录日志',
        ]);
    }

    public function actionOperateLog()
    {
        // 分页输出
        if(Yii::$app->request->isAjax)
        {
            // 搜索条件
            $where = [];
            $and_where = ['and'];
            $search = Yii::$app->request->get('search');
            if($search)
            {
                if($search['username'])
                {
                    $user_data = UserExtends::find()->where(['username' => $search['username']])->asArray()->one();
                    $where['userid'] = $user_data ? $user_data['userid'] : 0;
                }
                $search['ip'] && $where['ip'] = $search['ip'];
                if($search['created_at'])
                {
                    $date_array = explode(' ~ ', $search['created_at']);
                    $and_where[] = ['>=', 'created_at', strtotime($date_array[0])];
                    $and_where[] = ['<=', 'created_at', strtotime($date_array[1])];
                }
                $search['url'] && $and_where[] = ['like', 'url', $search['url'] . '%', false];
            }

            // 分页信息
            $page = Yii::$app->request->get('page');
            $limit = Yii::$app->request->get('limit');
            $offset = ($page - 1) * $limit;
            $count = AdminOperateLogExtends::find()->where($where)->andWhere($and_where)->count();

            $admin_operate_log_datas = AdminOperateLogExtends::find()->where($where)->andWhere($and_where)->orderBy(['created_at' => SORT_DESC, 'logid' => SORT_DESC])->offset($offset)->limit($limit)->asArray()->all();

            $echo_datas = [];
            if($admin_operate_log_datas)
            {
                $userids = array_unique(array_column($admin_operate_log_datas, 'userid'));
                $userid_username = [];
                foreach($userids as $userid)
                {
                    $admin_data = Yii::$app->mcache->getByKey('admin_datas', $userid);
                    $userid_username[$admin_data['userid']] = $admin_data['user']['username'];
                }
                foreach($admin_operate_log_datas as $k => $admin_operate_log_data)
                {
                    $echo_data = [
                        'logid' => Html::encode($admin_operate_log_data['logid']),
                        'userid_desc' => Html::encode($userid_username[$admin_operate_log_data['userid']]),
                        'url' => Html::encode($admin_operate_log_data['url']),
                        'ip' => Html::encode($admin_operate_log_data['ip']),
                        'created_at_desc' => Html::encode(Common::dateFormat($admin_operate_log_data['created_at'])),
                    ];

                    $echo_datas[] = $echo_data;
                }
            }

            return Common::echoJson(1000, '', $echo_datas, $count);
        }

        return $this->render('operate_log', [
            'title' => '操作日志',
        ]);
    }

    public function actionUpdateCache()
    {
        Yii::$app->cache->flush();

        return $this->render('update_cache', [
            'title' => '更新缓存',
        ]);
    }

    public function actionLog()
    {
        // 分页输出
        if(Yii::$app->request->isAjax)
        {
            // 搜索条件
            $where = [];

            // 分页信息
            $page = Yii::$app->request->get('page');
            $limit = Yii::$app->request->get('limit');
            $offset = ($page - 1) * $limit;
            $count = LogExtends::find()->where($where)->count();

            $datas = LogExtends::find()->where($where)->orderBy(['log_time' => SORT_DESC, 'id' => SORT_DESC])->offset($offset)->limit($limit)->asArray()->all();

            $echo_datas = [];
            foreach($datas as $data)
            {
                $echo_data = [
                    'id' => Html::encode($data['id']),
                    'level' => Html::encode($data['level']),
                    'category' => Html::encode($data['category']),
                    'log_time_desc' => Html::encode(Common::dateFormat($data['log_time'])),
                    'prefix' => Html::encode($data['prefix']),
                    'message' => Html::encode($data['message']),
                ];

                $echo_datas[] = $echo_data;
            }

            return Common::echoJson(1000, '', $echo_datas, $count);
        }

        return $this->render('log', [
            'title' => '系统日志',
        ]);
    }
}