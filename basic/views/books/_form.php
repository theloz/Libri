<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Libri */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libri-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ean13')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titolo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'autore')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'editore')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prezzo_copertina')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codice_collana')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'collana')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'argomento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'linea_prodotto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'disponibilita')->textInput() ?>

    <?= $form->field($model, 'create_dttm')->textInput() ?>

    <?= $form->field($model, 'mod_dttm')->textInput() ?>

    <?= $form->field($model, 'create_id')->textInput() ?>

    <?= $form->field($model, 'mod_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
