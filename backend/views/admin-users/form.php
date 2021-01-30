<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Url;
use common\libraries\CommonHtml;

$this->title = 'User Roles';
$this->params['breadcrumbs'][] = CommonHtml::bl($this->title,Url::to(['user-roles/index']));
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Add' : 'Update';

$formElements = [
    [
        'type'=>'text',
        'field'=>'name',
    ],
    [
        'type'=>'text',
        'field'=>'mobile',
    ],
    [
        'type'=>'text',
        'field'=>'username',
        'placeholder'=>'Email',
    ],
    [
        'type'=>'dropdown',
        'field'=>'role_id',
        'placeholder'=>'Select Role',
        'options'=>$this->context->roleNames ,
    ]
];

echo Yii::$app->controller->renderPartial("@app/views/render-partials/form_elements",compact('model','formElements'));
?>

