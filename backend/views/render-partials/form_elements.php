<?php
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

?>

<div class="col-md-12 m-t-25">
    <div class="card">
        <div class="card-header">
            <strong><?=$model->isNewRecord ? 'Create' : 'Edit'?></strong>
        </div>
        <div class="card-body card-block">
            <?php
               $form = ActiveForm::begin(['id' => $this->context->id.'form']);
               if(!empty($formElements)) {
                   foreach($formElements as $elements) {
                        $type = !empty($elements['type']) ? $elements['type'] : 'text';
                        $field = !empty($elements['field']) ? $elements['field'] : 'text';
                        $placeholder = !empty($elements['placeholder']) ? $elements['placeholder'] : ucfirst($field);
                        $hint = !empty($elements['hint']) ? $elements['hint'] : '';


                        switch($type) {
                            case 'text': 
                                echo $form->field($model, $field,[TEMPLATE=>FORM_TEMPLATE,'options'=>FORM_OPTIONS])->textInput(['autofocus' => true,'placeholder'=>$placeholder])
                                ->hint($hint);
                                break;
                            case 'dropdown':
                                $options = $elements['options'] ?? $elements['options'] ?? [];
                                echo $form->field($model, $field,[TEMPLATE=>FORM_TEMPLATE,'options'=>FORM_OPTIONS])->dropDownList($options,['prompt'=>$placeholder]);
                                break;

                        }
                   }
               }
            //    echo $form->field($model, 'username',[TEMPLATE=>FORM_TEMPLATE,'options'=>FORM_OPTIONS])->textInput(['autofocus' => true,'placeholder'=>'Name']);
            //    echo $form->field($model, 'email',[TEMPLATE=>FORM_TEMPLATE,'options'=>FORM_OPTIONS])->textInput(['autofocus' => true,'placeholder'=>'Name']);
               
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
