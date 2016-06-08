<?php

namespace mitrm\images\models;



use Imagine\Image\Box;
use Yii;
use yii\base\InvalidParamException;

use mitrm\images\models\query\ImagesCommonQuery;
use mitrm\images\Module;
use yii\image\drivers\Image;

/**
 * Загрузка изображений
 *
 * This is the model class for table "images_common".
 *
 * @property integer $id
 * @property string $title
 * @property string $path
 * @property string $hash
 * @property string $name
 * @property string $exp
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 */
class ImagesCommon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images_common';
    }

    public static function find()
    {
        return new ImagesCommonQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'name', 'exp'], 'required'],
            [['is_active', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 250],
            [['path'], 'string', 'max' => 100],
            [['hash'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 50],
            [['exp'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'path' => 'Пусть к файлу',
            'hash' => 'token',
            'name' => 'Имя',
            'exp' => 'Расширение',
            'is_active' => 'Активен',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
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
     * @brief Отдает оригинал загруженного изображения
     * @param int $size
     * @return string
     */
    public function getImgOrigin()
    {
        return $file = Module::$base_dir.'/'.$this->name.'.'.$this->exp;
    }


    /**
     * @brief Отдает изображение под нужный размер
     * @detailed смотри self::getImg()
     * @param int $size
     * @return bool|string
     */
    public function getImage($size=500)
    {
        if(!in_array($size, Module::$allow_size)) {
            throw new InvalidParamException('Не верный размер');
        }
        return self::getImg($this->path, $this->name, $this->exp, $size);
    }


    /**
     * @brief Отдает изображение под нужный размер
     * @detailed если изображения нет под нужный размер, генерирует его в реальном времени
     * @param $img
     * @param int $size
     * @return bool|string
     */
    public static function getImg($path, $img, $exp, $size=500)
    {
        $dir = Yii::$app->getModule('images')->base_dir . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
        $path = self::getPathImg() . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
        $image = $dir . $img.'_'.$size.'x'.$size.$exp;
        $image_path = $path . $img.'_'.$size.'x'.$size.$exp;
        if(file_exists($image_path)) {
            return $image;
        } else {
            $file = $path . $img . $exp;
            if(!file_exists($file)) {
                return false;
            }

            $file_new = $path . $img.'_'.$size.'x'.$size.$exp;

            $imageTmp = Image::factory($file, Yii::$app->getModule('images')->image_driver);
            $imageTmp->resize($size,$size);
            $imageTmp->save($file_new, 100);

            //$imageTmp = Image::getImagine()->open($file)->resize(new Box($size,$size))->save($file_new);
            return $image;
        }
    }



    /**
     * @brief полный путь до папки с изображениями
     * @return bool|string
     */
    public static function getPathImg()
    {
        $filePath = Yii::$app->getModule('images')->base_path;
        return Yii::getAlias($filePath);
    }

}
