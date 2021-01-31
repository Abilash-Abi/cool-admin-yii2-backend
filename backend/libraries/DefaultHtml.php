<?php
namespace backend\libraries;

class DefaultHtml {
    public static function  navigation(array $navigations=[],$route){

        $menuWidget =[];

        //This loop return navigation detail to menu widget
        $outerCount=0;
        foreach($navigations as $navigation) {
            $menuWidget[$outerCount]['label'] = sprintf(MENU_LABEL,$navigation['icon'],$navigation['label']);
            $menuWidget[$outerCount]['url'] = $navigation['url'];
            $menuWidget[$outerCount]['active'] = in_array($route,$navigation['active']);
            $menuWidget[$outerCount]['visible'] = $navigation['visible'];
        
        
            if(!empty($navigation['submenu'])) {
                $menuWidget[$outerCount]['template'] = SUB_MENU_TEMPLATE;
                $menuWidget[$outerCount]['options'] = ['class'=>'has-sub'];
                $innerCount =0;
                foreach($navigation['submenu'] as $submenu){
                    $menuWidget[$outerCount]['items'][$innerCount]['label'] = sprintf(MENU_LABEL,$submenu['icon'],$submenu['label']);
                    $menuWidget[$outerCount]['items'][$innerCount]['url'] = $submenu['url'];
                    $menuWidget[$outerCount]['items'][$innerCount]['active'] = in_array($route,$navigation['active']);
                    $menuWidget[$outerCount]['items'][$innerCount]['visible'] = $submenu['visible'];
                    $innerCount++;
                }
            }
            $outerCount++;
        }
        return $menuWidget;
        
    }
}