<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Libri */

$this->title = Yii::t('app','Create Books');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libri-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
