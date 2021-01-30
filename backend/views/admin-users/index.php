<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use common\libraries\CommonHtml;
use common\models\AdminUsers;
$this->title = 'Admin Users';
$this->params['breadcrumbs'][] = $this->title;


$provider = new ActiveDataProvider([
    'query' => $posts,
    'pagination' => [
        'pageSize' => Yii::$app->params['pageLimit'],
    ],
]);


?>
<div class="col-md-12 m-t-25">
    <?php


    $filterElements = [
        'fields'=>[
            [
                'type'=>'text',
                'name'=>'search',
                'placeholder'=>'Name / Email',
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
        


// Table Columns
$columns =  [
    ['class' => 'yii\grid\SerialColumn'],
   [
       'label'=>'Name',
       'value'=>'name'
   ],
   [
    'label'=>'Email',
    'value'=>'email'
    ],
    [
        'label'=>'Role',
        'value'=>'adminRole.role_name'
    ],
 
    [
        'label'=>'status',
        'format'=>'raw',
        'value'=>function($model) { return CommonHtml::statusButton($model->status,$model->id,AdminUsers::class); }
    ],
    [
        'class' => ActionColumn::className(),
        'template'=>'<div class="table-data-feature justify-content-start">{update}{delete}</div>',
        'header'=>'Action',
        'buttons' => [
            'update'=> function ($url,$model) {
                return CommonHtml::button([
                    'module'=>MANAGE_ADMIN_USERS,
                    'action'=>'edit',
                    'url'=>$url,
                    'class'=>'item',
                    'label'=>'<i class="zmdi zmdi-edit"></i>',
                ]);
            },
            'delete'=> function ($url,$model) {
                return CommonHtml::button([
                    'module'=>MANAGE_ADMIN_USERS,
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
            'dataProvider' => $provider,
            'layout'=>TABLE_LAYOUT,
            'emptyTextOptions'=>EMPTY_TEXT_OPTIONS,
            'emptyText'=>EMPTY_TEXT,
            'tableOptions'=>TABLE_OPTIONS,
            'pager'=>PAGINATION,
            'columns' =>$columns,
        ]);                                                                         
?>

</div>


