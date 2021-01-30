<?php
use yii\helpers\Url;
use common\libraries\CommonHtml;

$this->title = 'Category';
$this->params['breadcrumbs'][] =  CommonHtml::bl('Categories',Url::to(['index']));
$this->params['breadcrumbs'][] =  $model->isNewRecord ? 'Add' : 'Update';;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */

$formElements = [
 
        [
            'type'=>'text',
            'field'=>'name',
        ],
 
       
];
echo Yii::$app->controller->renderPartial("@app/views/render-partials/form_elements",compact('model','formElements'));


