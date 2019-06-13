<?php

namespace app_backend\controllers;

use Yii;
use yii\helpers\Html;

use common\helpers\Common;

use app_backend\models\AdminExtends;
use app_backend\models\UserExtends;

use app_backend\forms\Permission\AdminAddForm;
use app_backend\forms\Permission\AdminEditForm;

class PermissionController extends MosController
{
    public function actionAdmin()
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
                $search['userid'] && $where[AdminExtends::tableName() . '.userid'] = $search['userid'];
                $search['name'] && $where[AdminExtends::tableName() . '.name'] = $search['name'];
                is_numeric($search['disabled']) && $where[AdminExtends::tableName() . '.disabled'] = $search['disabled'];
                $search['username'] && $and_where[] = ['like', UserExtends::tableName() . '.username', $search['username'] . '%', false];
            }

            // 分页信息
            $page = Yii::$app->request->get('page');
            $limit = Yii::$app->request->get('limit');
            $offset = ($page - 1) * $limit;
            $count = AdminExtends::find()->joinWith('user')->where($where)->andWhere($and_where)->count();

            $admin_datas = AdminExtends::find()->joinWith('user')->where($where)->andWhere($and_where)->orderBy([AdminExtends::tableName() . '.created_at' => SORT_DESC, AdminExtends::tableName() . '.userid' => SORT_DESC])->offset($offset)->limit($limit)->asArray()->all();

            $echo_datas = [];
            foreach($admin_datas as $k => $admin_data)
            {
                $echo_data = [
                    'userid' => Html::encode($admin_data['userid']),
                    'username' => Html::encode($admin_data['user']['username']),
                    'name' => Html::encode($admin_data['name']),
                    'disabled' => Html::encode($admin_data['disabled']),
                    'disabled_desc' => Html::encode(AdminExtends::$disabled[$admin_data['disabled']]),
                ];

                $echo_datas[] = $echo_data;
            }

            return Common::echoJson(1000, '', $echo_datas, $count);
        }

        return $this->render('admin', [
            'title' => '管理员',
            'disabled_k_v' => AdminExtends::$disabled,
        ]);
    }

    public function actionAdminAdd()
    {
        $AdminAddForm = new AdminAddForm();
        if($AdminAddForm->load(Yii::$app->request->post()))
        {
            if($AdminAddForm->save())
            {
                return Common::echoJson(1000, '保存成功');
            } else {
                return Common::echoJson(1001, implode('<br>', $AdminAddForm->getFirstErrors()));
            }
        }

        return $this->render('admin_add', [
            'title' => '添加管理员',
            'disabled_k_v' => AdminExtends::$disabled,
            'sex_k_v' => AdminExtends::$sex,
        ]);
    }

    public function actionAdminEdit()
    {
        $userid = Yii::$app->request->get('userid');

        $admin_cache_data = Yii::$app->mcache->getByKey('admin_datas', $userid);
        if(!$admin_cache_data)
        {
            return Common::echoJson(1001, '请选择操作用户');
        } elseif($userid == 1) {
            return Common::echoJson(1002, "禁止编辑管理员“{$admin_cache_data['user']['username']}”");
        }

        $AdminEditForm = new AdminEditForm();
        if($AdminEditForm->load(Yii::$app->request->post()))
        {
            if($AdminEditForm->save($userid))
            {
                return Common::echoJson(1000, '保存成功');
            } else {
                return Common::echoJson(1003, implode('<br>', $AdminEditForm->getFirstErrors()));
            }
        }

        return $this->render('admin_edit', [
            'title' => '编辑管理员',
            'admin_data' => $admin_cache_data,
            'disabled_k_v' => AdminExtends::$disabled,
            'sex_k_v' => AdminExtends::$sex,
        ]);
    }

    public function actionAdminDel()
    {
        $userid = Yii::$app->request->get('userid');

        $admin_cache_data = Yii::$app->mcache->getByKey('admin_datas', $userid);
        if(!$admin_cache_data)
        {
            return Common::echoJson(1001, '请选择操作用户');
        } elseif($userid == 1) {
            return Common::echoJson(1002, "禁止删除管理员“{$admin_cache_data['user']['username']}”");
        }

        $Admin = AdminExtends::findOne($userid);
        if($Admin->deleteRelationAll())
        {
            return Common::echoJson(1000, '删除成功');
        } else {
            return Common::echoJson(1003, implode('<br>', $Admin->getFirstErrors()));
        }
    }
}