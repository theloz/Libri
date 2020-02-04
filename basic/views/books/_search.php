<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\LibriSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libri-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codice') ?>

    <?= $form->field($model, 'ean13') ?>

    <?= $form->field($model, 'titolo') ?>

    <?= $form->field($model, 'autore') ?>

    <?php // echo $form->field($model, 'editore') ?>

    <?php // echo $form->field($model, 'prezzo_copertina') ?>

    <?php // echo $form->field($model, 'codice_collana') ?>

    <?php // echo $form->field($model, 'collana') ?>

    <?php // echo $form->field($model, 'argomento') ?>

    <?php // echo $form->field($model, 'linea_prodotto') ?>

    <?php // echo $form->field($model, 'disponibilita') ?>

    <?php // echo $form->field($model, 'create_dttm') ?>

    <?php // echo $form->field($model, 'mod_dttm') ?>

    <?php // echo $form->field($model, 'create_id') ?>

    <?php // echo $form->field($model, 'mod_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
