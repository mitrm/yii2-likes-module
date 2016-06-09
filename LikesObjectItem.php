<?php

namespace mitrm\likes\models;

use Yii;

/**
 * This is the model class for table "likes_object_item".
 *
 * @property integer $id
 * @property integer $likes_object_id
 * @property integer $user_id
 * @property integer $num
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property LikesObject $likesObject
 */
class LikesObjectItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likes_object_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['likes_object_id', 'user_id', 'num', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'likes_object_id' => 'Likes Object ID',
            'user_id' => 'User ID',
            'num' => 'Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikesObject()
    {
        return $this->hasOne(LikesObject::className(), ['id' => 'likes_object_id']);
    }
    
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->changeSum();

    }


    public function changeSum()
    {
        $object = LikesObject::find()
            ->where(['id' => $this->likes_object_id])
            ->one();

        $sum = self::find()
            ->where(['likes_object_id' => $this->likes_object_id])
            ->sum('num');

        $object->sum_likes = $sum;
        if(!$object->save()) {
            Yii::error([
                'msg' => 'Ошибка сохранения количество лайков',
                'data' => [
                    'errors' => $object->errors,
                    'method' => __METHOD__
                ],
            ]);
        }
    }



    /**
    *
    static function getStatus($id=false)
	{
		$data = [
                self::STATUS_ACTIVE => 'Отображается',
			];
        if($id !== false){
            return $data[$id];
        }
        return $data;
	}
    *
    *
    */
}
