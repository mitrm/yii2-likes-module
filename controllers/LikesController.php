<?php

namespace mitrm\links\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class LikesController extends Controller
{
    public function actionLike()
    {
        $post = Yii::$app->request->post();
        $field_id = $post['field_id'];
        $user_id = Yii::$app->user->id;

        if($post['like'] == 1) {
            Yii::$app->likes->addLike(GamesCompany::tableName(), $company_id, $user_id);
        }
    }
}
