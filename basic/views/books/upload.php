<?php
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


$this->title = Yii::t('app','Catalogue upload');
?>
<?php 
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
echo $form->field($model, 'file')->widget(FileInput::classname(), [
    'options' => ['accept' => 'text/csv'],
]);
// echo $form->field($model, 'file')->fileInput();
?>

<button class="btn btn-info"><?=Yii::t('app','Upload')?></button>

<?php ActiveForm::end() ?>