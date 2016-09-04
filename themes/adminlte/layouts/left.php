<?php
if (!empty($this->context->sideBar)) {
    $sideBarMenus = $this->context->sideBar;
} elseif (!empty($this->context->module->menus)) {
    $sideBarMenus = $this->context->module->menus;
} else {
    $sideBarMenus = [
        ['label' => '用户管理', 'items' => [
            ['label' => '用户列表', 'url' => '/user/list'],
            ['label' => '添加用户', 'url' => '/user/add']
        ]],
        ['label' => Yii::t('w', 'menu task list'), 'url' => '/task/index'],
        ['label' => Yii::t('w', 'menu submit task'), 'url' => '/task/submit'],
        ['label' => Yii::t('w', 'menu file md5'), 'url' => '/walle/check'],
        ['label' => Yii::t('w', 'menu config project'), 'url' => '/conf', 'visible' => \Yii::$app->user->identity->role == app\models\User::ROLE_ADMIN],
    ];
}
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <!--<img src="<?= \app\components\GlobalHelper::formatAvatar(\Yii::$app->user->identity->avatar) ?>" class="img-circle" alt="User Image"/>-->
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <?php /* <p><?= \Yii::$app->user->identity->username ?></p> */ ?>
                <p> 你好，<?= \Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i>欢迎登陆</a>
            </div>
        </div>

        <?php /*
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        */ ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $sideBarMenus, 
                /*
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                */
            ]
        ) ?>

    </section>

</aside>
