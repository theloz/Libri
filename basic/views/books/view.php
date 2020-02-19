<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Libri */

$this->title = $model->titolo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="libri-view row">
    <div class="col-lg-8">
        <p>
            <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'label' => '',
                    'format' => 'raw',
                    'value' => function($model){
                        return '<img src="https://img.fastbookspa.it/images/'.$model->ean13.'_0_230_350_0.jpg" />';
                    },
                ],
                'codice',
                'ean13',
                [
                    'attribute'=>'titolo',
                    'value'=> function($model){
                        return utf8_decode($model->titolo);
                    }
                ],
                [
                    'attribute'=>'autore',
                    'value'=> function($model){
                        return utf8_decode($model->autore);
                    }
                ],
                [
                    'attribute'=>'editore',
                    'value'=> function($model){
                        return utf8_decode($model->editore);
                    }
                ],
                'prezzo_copertina',
                'prezzo_old',
                'prezzo_diff',
                'codice_collana',
                [
                    'attribute'=>'collana',
                    'value'=> function($model){
                        return utf8_decode($model->collana);
                    }
                ],
                'argomento',
                [
                    'attribute'=>'linea_prodotto',
                    'value'=> function($model){
                        return utf8_decode($model->linea_prodotto);
                    }
                ],
                'disponibilita',
                'disponibilita_old',
                'disponibilita_diff',
                'create_dttm:datetime',
                'mod_dttm:datetime',
                [
                    'attribute'=>'create_id',
                    'type'=>'raw',
                    'value'=> function($model){
                        return $model->createUser->first_name." ".$model->createUser->last_name;
                    }
                ],
                [
                    'attribute'=>'mod_id',
                    'type'=>'raw',
                    'value'=> function($model){
                        return $model->modifyUser->first_name." ".$model->modifyUser->last_name;
                    }
                ],
            ],
        ]) ?>

    </div>
    <div class="col-lg-4">
            <?php
            echo $this->render('_view-book-details',[
                'model' => $model,
                'priceDataProvider' => $priceDataProvider,
                'availDataProvider' => $availDataProvider,
            ]);
            ?>
    </div>
</div>
