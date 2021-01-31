<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use Yii;
/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/backend/web/files/';
    public $sourcePath = '@yii/assets';
    
    public $css = [

    // Fontfaces CSS
        'css/font-face.css',
        'vendor/font-awesome-4.7/css/font-awesome.min.css',
        'vendor/font-awesome-5/css/fontawesome-all.min.css',
        'vendor/mdi-font/css/material-design-iconic-font.min.css',
    
    // Bootstrap CSS
        'vendor/bootstrap-4.1/bootstrap.min.css',

    // Vendor CSS
        'vendor/animsition/animsition.min.css',
        'vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css',
        'vendor/wow/animate.css',
        'vendor/css-hamburgers/hamburgers.min.css',
        'vendor/slick/slick.css',
        'vendor/select2/select2.min.css',
        'vendor/perfect-scrollbar/perfect-scrollbar.css',
        // 'vendor/vector-map/jqvmap.min.css',
        'https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css',
    
    // Main CSS
        'css/theme.css',


    ];
    public $js = [
    // //   Bootstrap JS
        'vendor/bootstrap-4.1/popper.min.js',
        'vendor/bootstrap-4.1/bootstrap.min.js',

    // //  Vendor JS
        'vendor/slick/slick.min.js',
        'vendor/wow/wow.min.js',
        'vendor/animsition/animsition.min.js',
        'vendor/bootstrap-progressbar/bootstrap-progressbar.min.js',
        // 'vendor/counter-up/jquery.waypoints.min.js',
        'vendor/counter-up/jquery.counterup.min.js',
        'vendor/circle-progress/circle-progress.min.js',
        'vendor/perfect-scrollbar/perfect-scrollbar.js',
        'vendor/chartjs/Chart.bundle.min.js',
        'vendor/select2/select2.min.js',
        // 'vendor/vector-map/jquery.vmap.js',
        // 'vendor/vector-map/jquery.vmap.min.js',
        // 'vendor/vector-map/jquery.vmap.sampledata.js',
        // 'vendor/vector-map/jquery.vmap.world.js',
    'https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js',
    // //  Main JS
        'js/main.js'
    ];
   
    public function __construct(){
        $route = Yii::$app->controller->route;

        $needToastAndConfirm = [
            'user-roles/index',
            'admin-users/index',
            'category/index',
        ];

    
         // Confirm Select picker js and css
         if(in_array($route,$needToastAndConfirm)){
            $this->css[] = 'css/jquery.toast.min.css';
            $this->css[] = 'css/jquery-confirm.min.css';
            
            $this->js[] = 'js/jquery-confirm.min.js';
            $this->js[] = 'js/jquery.toast.min.js';
            $this->js[] = 'js/toast.js';
        }
    
    }

}
