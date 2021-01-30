<?php
namespace common\libraries;

use common\components\PermissionControl;
use yii\helpers\Url;
use yii\helpers\Html;

use Yii;
class CommonHtml {

    /**
     * @param $messageKey - Key name of messagess
     * @param $param array to pass the message string
     * eg 
     * flashSuccess('roleCreate',['name'=>'Test'])
     */
    public static function flashSuccess($messageKey,array $param=[]){
        Yii::$app->session->setFlash(SUCCESS, Yii::t('users/alerts',$messageKey,$param));
    }
    public static function flashError($messageKey,array $param=[]){
        Yii::$app->session->setFlash(ERROR, Yii::t('users/alerts',$messageKey,$param));
    }

    public static function statusButton(string $selectedStatus,$id=0,$model){
        $onColor = ($selectedStatus=='Active') ? 'success' : 'danger';
        $ofColor = ($selectedStatus=='Active') ? 'danger' : 'success';

        $offStatus = ($selectedStatus=='Active') ? 'Inactive' : 'Active';
        return '<input type="checkbox" checked data-toggle="toggle" data-model="'.$model.'" data-id="'.$id.'" class="status-action" data-on="'.$selectedStatus.'" data-off="'.$offStatus.'" data-onstyle="'.$onColor.'" data-offstyle="'.$ofColor.'">';
    }

    
public static function button(array $options = []){
    $url = !empty($options['url']) ? $options['url'] : '#';
    $module  = !empty($options['module']) ? $options['module'] : '';
    $action  = !empty($options['action']) ? $options['action'] : '';

    $class  = !empty($options['class']) ? $options['class'] : '';
    $label  = !empty($options['label']) ? $options['label'] : '';
    $title  = !empty($options['title']) ? $options['title'] : ucfirst($action);
    if(PermissionControl::isAllowed($module,$action)) {
    return Html::a($label,$url,['class'=>$class,'data-toggle'=>'tooltip','data-original-title'=>$title]);
    }
}

    /**
     * Get Url Param
     * Return Url with the params
     * @param $URl -> array with url and required params
     * @param $result default all, specify the url
     */
    public static function getExportUrl(array $baseUrl,string $result='all') {

        $exportUrl = ['export'=>$result];
        $baseUrl = array_merge($baseUrl,$exportUrl);
        $fullUrl =  parse_url($_SERVER['REQUEST_URI'], -1 );
        $urlParamArray =[];
        !empty($fullUrl['query']) ? parse_str($fullUrl['query'],$urlParamArray): '';
        return Url::to(array_merge($baseUrl,$urlParamArray));
    } 

      /**
     * Check url param is empty
     * return true if param is not empty
     */
    public static function isUrlParams(array $removeQuery =[]){
        $fullUrl =  parse_url($_SERVER['REQUEST_URI'], -1 );
        $urlParams=[];
        if(!empty($fullUrl['query'])){
            parse_str($fullUrl['query'],$urlParams);

        }
        return !empty(CommonHtml::arrayRemove($urlParams,$removeQuery)) ? true : false;
    }

        
    public static function arrayRemove(array $fullArray=[],array $needToRemove=[]){
        return array_udiff(array_keys($fullArray),$needToRemove,function($a,$b){
             if ($a===$b)
             {
             return 0;
             }
             return ($a>$b)?1:-1;
        });
 
     } 

     public static function btnClearFilter(string $clearUrl='') {
         if(CommonHtml::isUrlParams()) {
            return ' <a class="btn btn-primary" href="'.Url::to($clearUrl).'">Clear</a>';
         }
     }

     
    /**
     * Bredcrumb label
     * @param $label -> label name
     * @params $link -> bredcrumb link , defacult void(0)
     * @return array 
     */
    public static function  bl(string $label, $link = 'JavaScript:void(0)') : array {

        return  ['label'=>$label.'<i class="fa fa-angle-right"></i>', 'class' => 'parent-item','url'=>$link];
}
}