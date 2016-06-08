<?php

use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View;
 */

?>


<?php Modal::begin([
     'header' => 'Загрузить изображение',
     'toggleButton' => $toggleButton,
 ]); ?>

<form action="<?= Url::toRoute(['/images/images-common/upload-modal'])?>" method="post" class="js_mitrm_img_upload_form"  enctype="multipart/form-data">
    <div class="col-md-8">
        <?= Html::fileInput('images', '' ,['class' => 'form-control', 'placeholder' => '', 'accept'=>'image/*'])?>
    </div>
    <div class="4">
        <?= Html::submitButton('Отправить', ['class' => 'js_mitrm_img_upload_submit pull-right btn btn-primary'])?>
    </div>
    <div class="clearfix"></div>
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken)?>
</form>

<div class="js_short_link_content" style="display: none; margin-top: 30px;">
    <?= Html::input('textarea', 'short_link', '' ,['class' => 'form-control js_short_link_result', 'placeholder' => 'Короткая ссылка'])?>
</div>


<?php Modal::end();?>
