<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Libri */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="libri-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'codice')->textInput(['maxlength' => true, 'disabled'=>true]) ?>
    <?= $form->field($model, 'ean13')->textInput(['maxlength' => true, 'disabled'=>true]) ?>
    <?= $form->field($model, 'titolo')->textInput(['maxlength' => true, 'value' => (isset($model->titolo) ? utf8_decode($model->titolo) : '') ]) ?>
    <?= $form->field($model, 'autore')->textInput(['maxlength' => true, 'value' => (isset($model->autore) ? utf8_decode($model->autore) : '') ]) ?>
    <?= $form->field($model, 'editore')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'prezzo_copertina')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'codice_collana')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'collana')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'argomento')->textInput(['maxlength' => true, 'value' => (isset($model->argomento) ? utf8_decode($model->argomento) : '') ]) ?>
    <?= $form->field($model, 'linea_prodotto')->textInput(['maxlength' => true, 'value' => (isset($model->linea_prodotto) ? utf8_decode($model->linea_prodotto) : '') ]) ?>
    <?= $form->field($model, 'disponibilita')->textInput() ?>
    <?php
    // echo $form->field($model, 'create_dttm')->textInput();
    // echo $form->field($model, 'mod_dttm')->textInput();
    // echo $form->field($model, 'create_id')->textInput();
    // echo $form->field($model, 'mod_id')->textInput();
    ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
