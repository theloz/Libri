<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use barcode\barcode\BarcodeGenerator as BarcodeGenerator;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Books');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libri-index">
    <p>
        <?php //echo Html::a(Yii::t('app','Create Books'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    yii\bootstrap\Modal::begin(['id' =>'modal']);
    yii\bootstrap\Modal::end();
    echo GridView::widget([
        'pager' => [
            'firstPageLabel' => Yii::t('app','First'),
            'lastPageLabel'  => Yii::t('app','Last')
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        // 'pjax' => true,
        'striped' => true,
        'hover' => true,
        'responsive' => true,
        'floatHeader'=>true,
        'panel' => ['type' => 'primary', 'heading' => ''],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => 'barcode',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column){
                    $optionsArray = [
                        'elementId'=> 'showBarcode-'.$model->id, /* div or canvas id*/
                        'value'=> $model->ean13, /* value for EAN 13 be careful to set right values for each barcode type */
                        'type'=>'ean13',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
                    ];
                    return '<div id="showBarcode-'.$model->id.'"></div>'.BarcodeGenerator::widget($optionsArray);
                }
            ],
            [
                'label' => 'Immagine',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column){
                    // return '<img src="https://img.fastbookspa.it/images/'.$model->ean13.'_0_230_350_0.jpg" width="100" />';
                    return Html::a('<img src="https://img.fastbookspa.it/images/'.$model->ean13.'_0_230_350_0.jpg" width="100" />', ['books/view-image', 'ean' => $model->ean13], ['class' => 'popupModal']);
                }
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                // uncomment below and comment detail if you need to render via ajax
                'detailUrl'=>Url::to(['/books/book-details']),
                // 'detail' => function ($model, $key, $index, $column) {
                //     return Yii::$app->controller->renderPartial('_book-details', ['model' => $model]);
                // },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            // 'codice',
            'ean13',
            'titolo',
            'autore',
            'editore',
            //'prezzo_copertina',
            [
                'label' =>  $dataProvider->getSort()->link('prezzo_copertina').' / '.
                            $dataProvider->getSort()->link('prezzo_old').' / '.
                            $dataProvider->getSort()->link('prezzo_diff'),
                'encodeLabel'   => false,
                'attribute'     => '',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column){
                    $currPrice = number_format((float)(str_replace(",",".",$model->prezzo_copertina)),2);
                    $prevPrice = $model->prezzo_old;
                    $diff = $model->prezzo_diff;
                    return  $currPrice.' / '.$prevPrice.' / '.($diff < 0 ? '<strong><span class="text-danger">'.$diff.'</span></strong>' : '<strong>'.$diff.'</strong>');
                }
            ],
            // 'codice_collana',
            // 'collana',
            // 'argomento',
            // 'linea_prodotto',
            // 'disponibilita',
            [
                'label' =>  $dataProvider->getSort()->link('disponibilita').' / '.
                            $dataProvider->getSort()->link('disponibilita_old').' / '.
                            $dataProvider->getSort()->link('disponibilita_diff'),
                'encodeLabel'   => false,
                'attribute'     => '',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column){
                    $currAvail = (int)$model->disponibilita;
                    $prevAvail = $model->disponibilita_old;
                    $diff = $model->disponibilita_diff;
                    return  $currAvail.' / '.$prevAvail.' / '.($diff < 0 ? '<strong><span class="text-danger">'.$diff.'</span></strong>' : '<strong>'.$diff.'</strong>');
                }
            ],
            'create_dttm:datetime',
            //'mod_dttm:datetime',
            //'create_id',
            //'mod_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        
        // 'toolbar' => [
        //     [
        //         'content'=>
        //             Html::button('<i class="glyphicon glyphicon-plus"></i>', [
        //                 'type'=>'button', 
        //                 'title'=>Yii::t('kvgrid', 'Add Book'), 
        //                 'class'=>'btn btn-success'
        //             ]) . ' '.
        //             Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
        //                 'class' => 'btn btn-secondary', 
        //                 'title' => Yii::t('kvgrid', 'Reset Grid')
        //             ]),
        //     ],
        //     '{export}',
        //     '{toggleData}'
        // ],
        // 'toggleDataContainer' => ['class' => 'btn-group-sm'],
        // 'exportContainer' => ['class' => 'btn-group-sm']
    ]); 
    ?>


</div>
<?php
$this->registerJs("$(function() {
    $('.popupModal').click(function(e) {
      e.preventDefault();
      $('#modal').modal('show').find('.modal-content')
      .load($(this).attr('href'));
    });
 });");