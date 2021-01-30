<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\libraries\CommonHtml;

$this->title = 'User Roles';
$this->params['breadcrumbs'][] = CommonHtml::bl($this->title,Url::to(['user-roles/index']));
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Add' : 'Update';
?>

<div class="col-md-12 m-t-25">
    <div class="card">
        <div class="card-header">
            <strong><?=$model->isNewRecord ? 'Create' : 'Edit'?></strong>
        </div>
        <div class="card-body card-block">
            <?php
               $form = ActiveForm::begin(['id' => 'login-form']);
               echo $form->field($model, 'role_name',[TEMPLATE=>FORM_TEMPLATE,'options'=>FORM_OPTIONS])->textInput(['autofocus' => true,'placeholder'=>'Role Name']);
               
               echo '</div>
                        <div class="card-footer">';
                            echo Html::submitButton('<i class="fa fa-dot-circle-o"></i> Submit', ['class' => 'btn btn-primary btn-sm mr-1']);
                            echo $model->isNewRecord ? Html::resetButton('<i class="fa fa-ban"></i> Reset', ['class' => 'btn btn-danger btn-sm mr-1']) : '';
                            echo Html::a('<i class="fa fa-angle-left"></i> Back',$this->context->indexUrl, ['class' => 'btn btn-info btn-sm mr-1']);

                echo '</div>';
                ActiveForm::end();
            ?>
        </div>
    </div>
</div>
