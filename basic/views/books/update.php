<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Libri */

$this->title = Yii::t('app','Update Book: ') . $model->titolo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->titolo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="libri-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
