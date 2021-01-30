<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\libraries\CommonHtml;
?>

    <div class="table-data__tool">
    <div class="table-data__tool-left">

        <?php 
        if(!empty($filterElements['fields'])) {
        $form = ActiveForm::begin(['method' => 'GET','action'=>[$this->context->route]]);
            foreach($filterElements['fields'] as $elements) {

                $type = $elements['type'];
                $name = $elements['name'];


                switch($type) {
                    case 'selectBox';
                    $values = $elements['values'];
                    $prompt = $elements['prompt'];

                    echo '<div class="rs-select2--light rs-select2--md">';
                    echo Html::dropDownList($name,[@$_GET[$name]],$values,['class'=>'js-select2 submit-form','prompt'=>$prompt]);
                    echo '<div class="dropDownSelect2"></div></div>';


                }
            }
        ?>

<button type="submit" class="btn btn-success">Submit</button>

                   <?=CommonHtml::btnClearFilter(Url::to([$this->context->route]))?>
            <?php 
            ActiveForm::end();
        }
            ?>
                        </div>


        <div class="table-data__tool-right">
            <?php 
                if(!empty($filterElements['create'])){
                    echo $filterElements['create'];
                }else {
?>
                <a href="<?=Url::to([Yii::$app->controller->id.'/create'])?>">
                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                <i class="zmdi zmdi-plus"></i>add item</button>
                </a>

<?php
                }
                if(empty($filterElements['export'])) {
?>
<a href="<?=CommonHtml::getExportUrl([$this->context->route])?>">
            <button class="au-btn au-btn-icon au-btn--blue au-btn--small">
                <i class="zmdi zmdi-file-text"></i>Export</button>
                </a>
<?php
                }
            ?>
         
                
        </div>
    </div>


    <?php
$this->registerJs("
$('.status-action').change(function() {
    let selected = $(this).data('on');
    let id = $(this).data('id');
    let model = $(this).data('model');
    let status = (selected=='Active') ? 'Inactive' : 'Active';

    $.post(
        '".Yii::$app->UrlManager->createAbsoluteUrl(['site/update-status'])."', 
        {id:id,model:model,status:status }, 
        function(res){
            $.toast('Status has been updated successfully.');
        }
     );
});
");
?>