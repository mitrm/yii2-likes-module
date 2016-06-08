<?php
namespace mitrm\images\widgets;


use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;
use mitrm\images\Asset;


class ImagesUploadWidget extends Widget
{
    public $toggleButton = [
        'label' => 'Загрузить',
        'tag' => 'a'
    ];

    public $table = null;

    public $field_id = 0;
    public $user_id = 0;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->user_id == 0 && !Yii::$app->user->isGuest) {
            $this->user_id = Yii::$app->user->id;
        }
        $this->registerClientScript();
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('index', ['toggleButton' => $this->toggleButton]);
    }
    /**
     * Register widget client scripts.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        Asset::register($view);
    }
}