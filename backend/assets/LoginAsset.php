<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
/**
 * Main backend application asset bundle.
 */
class  LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/backend/web/files/';
    public $sourcePath = '@yii/assets';
    
    public $css = [

    // Fontfaces CSS
        'css/font-face.css',
    
    // Bootstrap CSS
        'vendor/bootstrap-4.1/bootstrap.min.css',
 
    // Main CSS
        'css/theme.css'
    ];
    public $js = [

    // //   Bootstrap JS
        'vendor/bootstrap-4.1/bootstrap.min.js',

    // //  Vendor JS
        'vendor/animsition/animsition.min.js',
    // //  Main JS
        'js/main.js'
    ];
   
   
   
    // public $depends = [
    //     'yii\web\JqueryAsset',
    //     'yii\web\YiiAsset',
    //     'yii\bootstrap\BootstrapAsset',
    // ];
}
