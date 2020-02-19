<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$this->title = 'Log';
$this->params['breadcrumbs'][] = $this->title;
$tail = 2000;
?>
<div class="site-about">
    <h3><?=Yii::t('app','Last {tail} lines', ['tail' => $tail])?></h3>
    <pre>
    <?php
        $files = scandir(\Yii::getAlias('@app')."/log/", SCANDIR_SORT_DESCENDING);
        $newest_file = $files[0];
        $lines = file(\Yii::getAlias('@app')."/log/".$newest_file);
        $tot = count($lines);
        $lastline = $tot - $tail;
        
        for($n = $tot-1; $n>=$lastline; $n--){
             echo $lines[$n];
        }
    ?>
    </pre>
</div>