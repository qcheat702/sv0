<?php

namespace sv\admin\controllers;

use Yii;
// use app\models\User;
use sv\admin\models\UserChangePassword;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * 修改本人的密码
 */
class ChangeMyPasswordController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['admin-change-my-password'],
                    ],
                ],
            ],
        ];
    }


/*    public function actionUpdate()
    {

        $uid = Yii::$app->user->identity->uid;
        $model = $this->findModel($uid);

        if(  Yii::$app->request->post()  ){

            $passwordck = Yii::$app->request->post('passwordck');
            if(  $model->encryptPassword($passwordck) != $model->password  )
                throw new NotFoundHttpException('原密码检查失败，无法修改新密码.');
            $password = Yii::$app->request->post('password');
            $passwordre = Yii::$app->request->post('passwordre');
            if(  $password != $passwordre  )
                throw new NotFoundHttpException('两次输入的密码不一致.');
            $model->password = $model->encryptPassword($password);

            if(  $model->save()  )
                 return $this->render('confirm');
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }
*/
    public function actionUpdate()
    {

        // $uid = Yii::$app->user->identity->uid;
        $model = UserChangePassword::findOne(Yii::$app->user->identity->ID);

         if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('confirm');
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }
 


}
