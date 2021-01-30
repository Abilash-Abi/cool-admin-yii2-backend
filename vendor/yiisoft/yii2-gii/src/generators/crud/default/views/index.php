<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\grid\ActionColumn;
use common\libraries\CommonHtml;
use yii\data\ActiveDataProvider;

use common\models\<?=$generator->modelClass?>;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
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
<?='<?php '?>
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

$columns  = [
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            if( $name=='status'){
                echo '
                [
                    \'label\'=>\'status\',
                    \'format\'=>\'raw\',
                    \'value\'=>function($model) { return CommonHtml::statusButton($model->status,$model->id,'.$generator->modelClass.'::class); }
                ],
                ';
            }else{
                echo "            '" . $name . "',\n";
            }
        } 
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

[
        'class' => ActionColumn::className(),
        'template'=>'<?='<div class="table-data-feature justify-content-start">{update}{delete}</div>'?>',
        'header'=>'Action',
        'buttons' => [
            'update'=> function ($url,$model) {
                return CommonHtml::button([
                    'module'=>MANAGE_ADMIN_USERS,
                    'action'=>'edit',
                    'url'=>$url,
                    'class'=>'item',
                    'label'=>'<?='<i class="zmdi zmdi-edit"></i>'?>',
                ]);
            },
            'delete'=> function ($url,$model) {
                return CommonHtml::button([
                    'module'=>MANAGE_ADMIN_USERS,
                    'action'=>'delete',
                    'url'=>$url,
                    'class'=>'item confirm-delete',
                    'label'=>'<?='<i class="zmdi zmdi-delete"></i>'?>',
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
