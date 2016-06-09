<?php

namespace mitrm\likes;

use Yii;
use yii\base\Component;

use mitrm\likes\models\LikesObject;
use mitrm\likes\models\LikesObjectItem;

/**
 * Class likes
 * The main class to wrap Kohana Image Extension
 * @package yii\image
 */
class Likes extends Component
{

    public function sum($table, $field_id){

        $object = LikesObject::find()
            ->where(['table' => $table, 'field_id' => $field_id])
            ->one();
        if(!$object || !is_int($object->sum_likes)) {
            return 0;
        }

        return $object->sum_likes;
    }

    public function likeUp($table, $field_id, $user_id=false, $num=1){
        $this->changeLike($table, $field_id, $user_id, $num);
    }

    public function likeDown($table, $field_id, $user_id=false, $num=-1){
        $this->changeLike($table, $field_id, $user_id, $num);
    }


    public function changeLike($table, $field_id, $user_id=false, $num)
    {
        if(!$user_id) {
            $user_id = Yii::$app->user->id;
        }
        $object = LikesObject::find()
            ->where(['table' => $table, 'field_id' => $field_id])
            ->one();
        if(!$object) {
            $object = new LikesObject();
            $object->table = $table;
            $object->field_id = $field_id;
            if(!$object->save()) {
                Yii::error([
                    'msg' => 'Ошибка создания объекта для лайка',
                    'data' => [
                        'errors' => $object->errors,
                        'method' => __METHOD__
                    ],
                ]);
            }
        }
        if($object) {
            $model = LikesObjectItem::find()
                ->where(['likes_object_id' => $object->id, 'user_id' => $user_id])
                ->one();
            if(!$model) {
                $model = new LikesObjectItem();
                $model->likes_object_id = $object->id;
                $model->user_id = $user_id;
            }
            $model->num = $num;
            if(!$model->save()) {
                Yii::error([
                    'msg' => 'Ошибка создания лайка',
                    'data' => [
                        'errors' => $object->errors,
                        'method' => __METHOD__
                    ],
                ]);
            }
        }
    }



}
?>