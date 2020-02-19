<h3><?=Yii::t('app','Last variations')?></h3>
<div class="row">
    <div class="col-lg-6">
        <h5><?=Yii::t('app','Prezzo Copertina')?></h5>
        <?php
        echo kartik\grid\GridView::widget([
            'dataProvider' => $priceDataProvider,
            'id' => 'pdp_'.$model->id,
            'columns' => [
                'old_value',
                'new_value',
                'diff_value',
                'change_dttm:datetime',
            ]
        ]);
        ?>
    </div>
    <div class="col-lg-6">
        <h5><?=Yii::t('app','Disponibilita')?></h5>
        <?php
        echo kartik\grid\GridView::widget([
            'dataProvider' => $availDataProvider,
            'id' => 'adp_'.$model->id,
            'columns' => [
                'old_value',
                'new_value',
                'diff_value',
                'change_dttm:datetime',
            ]
        ]);
        ?>
    </div>
</div>
<?php


?>
<h3><?=Yii::t('app','More informations')?></h3>
<?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'codice',
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
                    // return utf8_decode($model->linea_prodotto);
                    return utf8_decode($model->linea_prodotto);
                }
            ],
        ],
    ]); ?>