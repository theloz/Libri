<?php
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


$this->title = Yii::t('app','Catalogue upload');
?>
<?php 
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
echo $form->field($model, 'csvfile')->widget(FileInput::classname(), [
    'options' => ['accept' => 'text/csv'],
]);
// echo $form->field($model, 'separator')->textInput(['style'=> 'width:40px;', 'value'=>';']);
$model->separator = ";";
$model->firstline = "2";
echo $form->field($model, 'separator')->dropDownList(
    [';'=>';', ','=>','], 
    ['prompt'=>Yii::t('app','Select...')]);
echo $form->field($model, 'firstline')->textInput(['style'=> 'width:40px;']);
?>

<button class="btn btn-info"><?=Yii::t('app','Upload')?></button>

<?php ActiveForm::end() ?>