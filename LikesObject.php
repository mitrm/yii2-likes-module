<?php

namespace mitrm\likes\models;

use Yii;

/**
 * This is the model class for table "likes_object".
 *
 * @property integer $id
 * @property string $table
 * @property integer $field_id
 * @property integer $sum_likes
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property LikesObjectItem[] $likesObjectItems
 */
class LikesObject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likes_object';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id', 'sum_likes', 'created_at', 'updated_at'], 'integer'],
            [['table'], 'string', 'max' => 50],
            ['sum_likes', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table' => 'Table',
            'field_id' => 'Field ID',
            'sum_likes' => 'Sum Likes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikesObjectItems()
    {
        return $this->hasMany(LikesObjectItem::className(), ['likes_object_id' => 'id']);
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
