<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use common\libraries\CommonHtml;
use yii\data\ActiveDataProvider;

use common\models\common\models\Category;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => $posts,
    'pagination' => [
        'pageSize' => Yii::$app->params['pageLimit'],
    ],
    'sort' =>false,

]);
?>
<div class="col-md-12 m-t-25">
<?php $filterElements = [
        'fields'=>[
            [
                'type'=>'text',
                'name'=>'search',
                'placeholder'=>'Name',
            ],
                [
                    'type'=>'dropdown',
                    'name'=>'status',
                    'prompt'=>'Select Status',
                    'values'=> ['Active'=>'Active','Inactive'=>'Inactive']
                ]
        ]
    ];
echo Yii::$app->controller->renderPartial('@app/views/render-partials/_filter_section',compact('filterElements'));

$columns  = [
              [
                'class' => 'yii\grid\SerialColumn',
              ],
            'name',

                [
                    'label'=>'status',
                    'format'=>'raw',
                    'value'=>function($model) { return CommonHtml::statusButton($model->status,$model->id,common\models\Category::class); }
                ],

[
        'class' => ActionColumn::className(),
        'template'=>'<div class="table-data-feature justify-content-start">{update}{delete}</div>',
        'header'=>'Action',
        'buttons' => [
            'update'=> function ($url,$model) {
                return CommonHtml::button([
                    'module'=>$this->context->permissionModule,
                    'action'=>'edit',
                    'url'=>$url,
                    'class'=>'item',
                    'label'=>'<i class="zmdi zmdi-edit"></i>',
                ]);
            },
            'delete'=> function ($url,$model) {
                return CommonHtml::button([
                    'module'=>$this->context->permissionModule,
                    'action'=>'delete',
                    'url'=>$url,
                    'class'=>'item confirm-delete',
                    'label'=>'<i class="zmdi zmdi-delete"></i>',
                ]);

            },
        ],
        ]
    ];


    echo GridView::widget([
            'dataProvider' => $dataProvider,
            'layout'=>TABLE_LAYOUT,
            'emptyTextOptions'=>EMPTY_TEXT_OPTIONS,
            'emptyText'=>EMPTY_TEXT,
            'tableOptions'=>TABLE_OPTIONS,
            'pager'=>PAGINATION,
            'columns' =>$columns,
        ]);         
    ?>
</div>
