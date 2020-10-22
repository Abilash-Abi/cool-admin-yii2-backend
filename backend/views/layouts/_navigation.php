<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Menu;

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

$navigations = [
    [
        'label'=>'Dashboard', 'icon'=>'fas fa-tachometer-alt', 'url'=>'#','visible'=>1,
            'active'=>['site/login'],
        'submenu'=>[
                ['label'=>'Dashboard', 'icon'=>'fas fa-tachometer-alt', 'url'=>['site/index'],'visible'=>1,
                'active'=>['site/test']]
        ],
    ],
        ['label'=>'Listing', 'icon'=>'fas fa-tachometer-alt', 'url'=>['site/listing'],'visible'=>1,'active'=>['site/listing']],

];




$menuWidget =[];

//This loop return navigation detail to menu widget
$outerCount=0;
foreach($navigations as $navigation) {
    $menuWidget[$outerCount]['label'] = sprintf(MENU_LABEL,$navigation['icon'],$navigation['label']);
    $menuWidget[$outerCount]['url'] = $navigation['url'];
    $menuWidget[$outerCount]['active'] = in_array($this->context->route,$navigation['active']);
    $menuWidget[$outerCount]['visible'] = $navigation['visible'];


    if(!empty($navigation['submenu'])) {
        $menuWidget[$outerCount]['template'] = SUB_MENU_TEMPLATE;
        $menuWidget[$outerCount]['options'] = ['class'=>'has-sub'];
        $innerCount =0;
        foreach($navigation['submenu'] as $submenu){
            $menuWidget[$outerCount]['items'][$innerCount]['label'] = sprintf(MENU_LABEL,$submenu['icon'],$submenu['label']);
            $menuWidget[$outerCount]['items'][$innerCount]['url'] = $submenu['url'];
            $menuWidget[$outerCount]['items'][$innerCount]['active'] = in_array($this->context->route,$navigation['active']);
            $menuWidget[$outerCount]['items'][$innerCount]['visible'] = $submenu['visible'];
            $innerCount++;
        }
    }
    $outerCount++;
}

// echo '<pre>';    
// print_r($menuWidget);die;
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
        'items'=>$menuWidget,
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
