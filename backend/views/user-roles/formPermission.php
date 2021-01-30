<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\View;

use common\libraries\CommonHtml;
use common\libraries\Privileges;

use yii\data\ArrayDataProvider;
use yii\grid\GridView;



$this->title = 'Role Privileges';
$this->params['breadcrumbs'][] = CommonHtml::bl('User Roles',Url::to(['user-roles/index']));
$this->params['breadcrumbs'][] = 'Privileges';
$provider = new ArrayDataProvider([
    'allModels' => Privileges::permissions(),
    'keys'=> array_keys(Privileges::permissions()),
  
]);

$columns =[
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            [
                'label'=> 'Privilege',
                'format'=>'raw',
                'value'=>function($data,$key){return  $key;}
            ],
            [
                'label'=>'Permissions',
                'format'=>'raw',
                'value'=>function($data,$key,$index) {
                    $actions = $data;
                    $html ='<div class="row role-section" id="role-section-'.$index.'" value='.json_encode($actions,true).'>';
                    $rolePermissions = !empty($this->context->rolePermissions[$key]) ? $this->context->rolePermissions[$key] : [];
                    foreach($data as $value){
                    $checked = (in_array($value,$rolePermissions)) ? 'checked' : '';

                        $html .='
                        <div class="col-md-3 ">
                            <div class="form-check">
                                <div class="checkbox">
                                    <label for="RolePermissions[permissions]['.$key.'][]'.$value.'" class="form-check-label ">
                                        <input '.$checked.' type="checkbox" id="RolePermissions[permissions]['.$key.'][]'.$value.'" name="RolePermissions[permissions]['.$key.'][]'.$value.'" value="'.$value.'" class="form-check-input">'.$value.'
                                    </label>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    $html .='</div>';
                    return $html;
                }
            ]
        ];
?>


<div class="col-md-12 m-t-25">
<?php
$form = ActiveForm::begin(['id' => 'login-form']);
echo GridView::widget([
            'dataProvider' => $provider,
            'layout'=>TABLE_LAYOUT,
            'emptyTextOptions'=>EMPTY_TEXT_OPTIONS,
            'emptyText'=>EMPTY_TEXT,
            'tableOptions'=>TABLE_OPTIONS,
            'pager'=>PAGINATION,
            'columns' =>$columns,
        ]); 
        
        echo '<div class="">';
                            echo Html::submitButton('<i class="fa fa-dot-circle-o"></i> Submit', ['class' => 'btn btn-primary btn-sm mr-1']);
                            echo $model->isNewRecord ? Html::resetButton('<i class="fa fa-ban"></i> Reset', ['class' => 'btn btn-danger btn-sm mr-1']) : '';
                            echo Html::a('<i class="fa fa-angle-left"></i> Back',$this->context->indexUrl, ['class' => 'btn btn-info btn-sm mr-1']);

                echo '</div>';

ActiveForm::end();
        
        ?>
</div>


<?php
$this->registerJs(
    "$('.role-section :checkbox').change(function() {
	 if($(this).is(':checked')) {
        selectId = $(this).closest('.role-section').attr('id');	
        var strArray = this.value.split(' ');
        console.log(strArray.length);
        if(jQuery.inArray(strArray[0], ['add','edit','view','delete']) == -1){
            if(strArray.length < 3){
                console.log('#'+selectId+' input[value=' + strArray[0] + ']');
                $('#'+selectId+' input[value=' + strArray[0] + ']').prop('checked', true);
            }else{
                if(strArray[0]=='schedules' || strArray[0]=='students'){
                    $('#'+selectId+' input[value=' + strArray[0] + ']').prop('checked', true);
                }
               
                $('#'+selectId+' input[value=\"' + strArray[0] +' '+strArray[1] + '\"]').prop('checked', true);
            }
        }
        if(this.value != 'view'){
				selectId = $(this).closest('.role-section').attr('id');		
				$('#'+selectId+' input[type=checkbox]').each(function() {
					if(this.value =='view' && !$(this).is(':checked')){
						$(this).prop('checked', true);
					}
				});				
			}
	 }else{
        selectId = $(this).closest('.role-section').attr('id');	
        var strArray = this.value.split(' ');
        console.log(strArray.length);
        console.log('#'+selectId+' input[value=\"' + strArray[0] +strArray[1] + ' add\"]');
        if(strArray.length < 2){
            $('#'+selectId+' input[value=\"' + strArray[0] + ' add\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] + ' edit\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] + ' delete\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] + ' status update\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] + ' status\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] + ' publish\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] + ' manual notification\"]').prop('checked', false);
        }else {
            $('#'+selectId+' input[value=\"' + strArray[0] +' '+strArray[1] + ' add\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] +' '+strArray[1] +' edit\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] +' '+strArray[1] +' delete\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] +' '+strArray[1] +' status update\"]').prop('checked', false);
            $('#'+selectId+' input[value=\"' + strArray[0] +' '+strArray[1] +' status\"]').prop('checked', false);
        }
		if(this.value == 'view'){
			selectId = $(this).closest('.role-section').attr('id');		
			$('#'+selectId+' input[type=checkbox]').each(function() {	
                console.log(this.value);			
					$(this).prop('checked', false);				
			});
        }
           
        
     }
     
}); 

$('.select-on-check-all').on('click',function() {
    if($(this).prop('checked')){
        $('.form-check-input').prop('checked',true);

    }else {
        $('.form-check-input').prop('checked',false);

    }
});
    ",
    View::POS_READY,
    'delete-record-handler'
);
?>