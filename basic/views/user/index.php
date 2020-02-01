<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'first_name',
            'last_name',
            'phone_number',
            'username',
            //'useractive',
            //'email:email',
            //'password',
            //'authkey',
            //'password_reset_token',
            //'user_image',
            //'user_level',
            //'last_login',
            //'create_dttm',
            //'mod_dttm',
            //'create_id',
            //'mod_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
