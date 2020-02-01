<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/imgs/logo/logo.png" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->first_name." ".Yii::$app->user->identity->last_name?></p>
                <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
            </div>
        </div>

        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => Yii::t('app','Menu'), 'options' => ['class' => 'header']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => ['/site/index'], ],
                    ['label' => 'About', 'icon' => 'stethoscope', 'url' => ['/site/about'], ],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => Yii::t('app','Tools'),
                        'icon'  => 'tools',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible'=>(Yii::$app->user->identity->user_level=='admin' ? true : false)],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/site/debug']],
                        ]
                    ],
                    [
                        'label' => Yii::t('app','Catalogue'),
                        'icon' => 'book',
                        'url' => '#',
                        // 'options' =>['class' => 'menu-open',],
                        'items' => [
                            ['label' => Yii::t('app','File upload'), 'icon' => 'file-upload', 'url' => ['/books/upload'],],
                            ['label' => Yii::t('app','Book list'), 'icon' => 'swatchbook', 'url' => ['/books/index'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
