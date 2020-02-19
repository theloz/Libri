<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'LibriApp version 1.0';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <?php
    //echo count ($searchModel);
    date_default_timezone_set('Europe/Rome');
    $formatter = \Yii::$app->formatter;
    yii\bootstrap\Modal::begin(['id' =>'modal']);
    yii\bootstrap\Modal::end();
    ?>
    <section class="content">
        <div class="row">
            <div class="col-lg-3">
                <img src="/assets/imgs/logo/logo_transparent.png" alt="App Image" class="img-responsive" />
            </div>
            <div class="col-lg-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=Yii::t('app', 'Recently added')?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <?php
                            foreach($last as $l){
                                echo '
                                <li class="item">
                                    <div class="product-img">
                                        '.Html::a('<img src="https://img.fastbookspa.it/images/'.$l->ean13.'_0_50_50_0.jpg" alt="'.$l->titolo.'" />', ['books/view-image', 'ean' => $l->ean13], ['class' => 'popupModal']).'
                                    </div>
                                    <div class="product-info">
                                        '.Html::a($l->titolo, ['books/view', 'id'=>$l->id, ['class'=>'product-title']]).'
                                        <span class="label label-success pull-right">'.$l->prezzo_copertina.'€</span>
                                        <span class="product-description">
                                            '.Yii::t('app','Added on').' '.$formatter->asDate($l->create_dttm, 'long').' alle '.$formatter->asTime($l->create_dttm, 'short').'
                                        </span>
                                    </div>
                                </li>
                                ';
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <?php echo Html::a(Yii::t('app','View All Products'), 'books/index', ['class'=>'uppercase']) ?>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=Yii::t('app', 'Price recently modified')?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <?php
                            foreach($lastPrice as $l){
                                echo '
                                <li class="item">
                                    <div class="product-img">
                                    '.Html::a('<img src="https://img.fastbookspa.it/images/'.$l->ean13.'_0_50_50_0.jpg" alt="'.$l->titolo.'" />', ['books/view-image', 'ean' => $l->ean13], ['class' => 'popupModal']).'
                                    </div>
                                    <div class="product-info">
                                        '.Html::a($l->titolo, ['books/view', 'id'=>$l->id, ['class'=>'product-title']]).'
                                        <span class="label label-success pull-right">'.$l->prezzo_copertina.'€</span><br />
                                        <span class="label label-info pull-right">'.$l->prezzo_old.'€</span><br />
                                        <span class="product-description">
                                            '.Yii::t('app','Added on').' '.$formatter->asDate($l->create_dttm, 'long').' alle '.$formatter->asTime($l->create_dttm, 'short').'
                                        </span>
                                    </div>
                                </li>
                                ';
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <?php echo Html::a(Yii::t('app','View All Products'), 'books/index', ['class'=>'uppercase']) ?>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=Yii::t('app', 'Availability recently modified')?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <?php
                            foreach($lastAvailability as $l){
                                echo '
                                <li class="item">
                                    <div class="product-img">
                                    '.Html::a('<img src="https://img.fastbookspa.it/images/'.$l->ean13.'_0_50_50_0.jpg" alt="'.$l->titolo.'" />', ['books/view-image', 'ean' => $l->ean13], ['class' => 'popupModal']).'
                                    </div>
                                    <div class="product-info">
                                    '.Html::a($l->titolo, ['books/view', 'id'=>$l->id, ['class'=>'product-title']]).'
                                        <span class="label label-success pull-right">'.$l->disponibilita.'</span><br />
                                        <span class="label label-info pull-right">'.$l->disponibilita_old.'</span>
                                        <span class="product-description">
                                            '.Yii::t('app','Added on').' '.$formatter->asDate($l->create_dttm, 'long').' alle '.$formatter->asTime($l->create_dttm, 'short').'
                                        </span>
                                    </div>
                                </li>
                                ';
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <?php echo Html::a(Yii::t('app','View All Products'), 'books/index', ['class'=>'uppercase']) ?>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-5 col-lg-5 col-md-offset-3 col-lg-offset-3">
            
        </div>
    </div>

    <div class="body-content">
        
    </div>
</div>
<?php
$this->registerJs("$(function() {
    $('.popupModal').click(function(e) {
      e.preventDefault();
      $('#modal').modal('show').find('.modal-content')
      .load($(this).attr('href'));
    });
 });");
