<?php
namespace common\libraries;
use Yii;
class Db {
     /**
    * check data exist 
    *if exist return model or redirect previous page with error
    */
    public static function  getModel($class,array $fields) 
    {
        $model = $class::findOne($fields);
        if (!empty($model)) {
            return $model;
        } else {
            Yii::$app->session->setFlash(ERROR,  Yii::t('users/alert','dataNotExist'));
            Yii::$app->getResponse()->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            Yii::$app->end();
        }
    }
}

