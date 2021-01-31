<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Menu;
use common\components\PermissionControl;
use backend\libraries\DefaultHtml;
const MAIN_MENU_TEMPLATE =  "\n<ul class='list-unstyled navbar__sub-list js-sub-list'>\n{items}\n</ul>\n";
const SUB_MENU_TEMPLATE ='<a class="js-arrow" href="{url}">{label}<span class="arrow"><i class="fas fa-angle-down"></i></span></a>';

const MENU_LABEL = '<i class="%s"></i>%s';


/**
 * Set navigation
 * Props
 * label -> Menu name
 * icon -> icon class for menu
 * url -> href link to the menu
 * active ->  Controller functions, The menu will active when running the controller functions
 * visible -> Decide the menu visible or not
 */

 $adminUsers = PermissionControl::isAllowed(MANAGE_ADMIN_USERS,'view');
 $adminUserRoles = PermissionControl::isAllowed(MANAGE_USER_ROLES,'view');
 $manageCategory = PermissionControl::isAllowed(MANAGE_CATEGORY,'view');

$navigations = [
    [
        'label'=>'Dashboard', 'icon'=>'fas fa-tachometer-alt', 'url'=>'#','visible'=>1,
            'active'=>['site/login'],
    ],
    [
        'label'=>'Category', 'icon'=>'fas fa-list', 'url'=>['category/index'],'visible'=>$manageCategory,
            'active'=>['category/index','category/create','category/update'],
    ],
    [
        'label'=>'Admin Users', 'icon'=>'fas fa-users', 'url'=>'#','visible'=>$adminUsers || $adminUserRoles,
            'active'=>['user-roles/index'],
        'submenu'=>[
                ['label'=>'Users', 'icon'=>'fas fa-user', 'url'=>['admin-users/index'],'visible'=>$adminUsers,
                'active'=>['site/test']],
                
                ['label'=>'User Roles', 'icon'=>'fas fa-tachometer-alt', 'url'=>['user-roles/index'],'visible'=>$adminUserRoles,
                'active'=>['user-roles/index']]
        ],
    ],
        ['label'=>'Listing', 'icon'=>'fas fa-tachometer-alt', 'url'=>['site/listing'],'visible'=>1,'active'=>['site/listing']],

];


?>
<div class = 'logo'>
    <a href = '#'>
        <img src = 'images/icon/logo.png' alt = 'Cool Admin' />
    </a>
</div>
<div class = 'menu-sidebar__content js-scrollbar1'>
    <nav class = 'navbar-sidebar2'>
        <?php
        echo Menu::widget( [
        'items'=>DefaultHtml::navigation($navigations,$this->context->route),
            'options' => [
                'class' => 'list-unstyled navbar__list',
            ],
            'submenuTemplate' => MAIN_MENU_TEMPLATE,
            'activateItems' => true,
            'activateParents' => true,
            //   'activeCssClass' => '',
            'encodeLabels' => false,
            'labelTemplate' =>'{label}',
            'linkTemplate' => '<a href="{url}">{label}</a>'
        ] );
        ?>
    </nav>
</div>
