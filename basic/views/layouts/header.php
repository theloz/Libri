<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only"><?=Yii::t('app','Toggle navigation')?></span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        $avatar = "/assets/imgs/".( (Yii::$app->user->identity->user_image == '' ) ? "male-user.svg" : Yii::$app->user->identity->user_image);
                        ?>
                        <img src="<?= $avatar ?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?=Yii::$app->user->identity->first_name." ".Yii::$app->user->identity->last_name?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $avatar ?>" class="img-circle" alt="User Image"/>
                            <p>
                                <?php
                                echo Yii::$app->user->identity->first_name." ".Yii::$app->user->identity->last_name;
                                echo " - ".Yii::$app->user->identity->user_level;
                                echo "<small>".Yii::t('app', 'Last login')." ".\Yii::$app->formatter->asDatetime(Yii::$app->user->identity->last_login,'long')."</small>";
                                ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    Yii::t('app','Profile'),
                                    ['/user/view', 'id' => Yii::$app->user->identity->id],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    Yii::t('app','Sign out'),
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
