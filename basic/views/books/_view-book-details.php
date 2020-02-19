<h3><?=Yii::t('app','Last variations')?></h3>
<h5><?=Yii::t('app','Prezzo Copertina')?></h5>
<?php
echo kartik\grid\GridView::widget([
    'dataProvider' => $priceDataProvider,
    'id' => 'pdp_'.$model->id,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'old_value',
        'new_value',
        'diff_value',
        'change_dttm:datetime',
    ]
]);
?>
<h5><?=Yii::t('app','Disponibilita')?></h5>
<?php
echo kartik\grid\GridView::widget([
    'dataProvider' => $availDataProvider,
    'id' => 'adp_'.$model->id,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'old_value',
        'new_value',
        'diff_value',
        'change_dttm:datetime',
    ]
]);