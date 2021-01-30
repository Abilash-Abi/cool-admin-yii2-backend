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
    'models' => Privileges::permissions(),
    'keys'=> array_keys(Privileges::permissions()),
  
]);

$columns =[
          
            [
                'label'=> 'Privilege',
                'format'=>'raw',
                'value'=>function($data,$key){return  $key;}
            ],
            [   
                'label'=>'Permissions',
                'format'=>'raw',
                'value'=>function($data,$key,$index) {
                    $rolePermissions = !empty($this->context->rolePermissions[$key]) ? $this->context->rolePermissions[$key] : [];
                    $actions = $data;
                    $html ='<div class="row role-section" id="role-section-'.$index.'" value='.json_encode($actions,true).'>';
                    foreach($data as $value){
                    $icon = (in_array($value,$rolePermissions)) ? 'fa fa-check text-success' : 'fa fa-close text-danger';

                        $html .='
                        <div class="col-md-3 ">
                        <i class="'.$icon.'" aria-hidden="true"></i> '.$value.'
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

$filterElements = [
    'export'=>'show',
    'create'=>'<a href="'.Url::to(['user-roles/update-privileges','id'=>$_GET['id']]).'">
    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
        <i class="zmdi zmdi-edit"></i>Edit</button>
        </a>',
];
    echo Yii::$app->controller->renderPartial('@app/views/render-partials/_filter_section',compact('filterElements'));
    
echo GridView::widget([
            'dataProvider' => $provider,
            'layout'=>TABLE_LAYOUT,
            'emptyTextOptions'=>EMPTY_TEXT_OPTIONS,
            'emptyText'=>EMPTY_TEXT,
            'tableOptions'=>TABLE_OPTIONS,
            'pager'=>PAGINATION,
            'columns' =>$columns,
        ]);       ?>
</div>

