<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}


echo "<?php\n";
?>
use yii\helpers\Url;
use common\libraries\CommonHtml;

$this->title = <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] =  CommonHtml::bl(<?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>,Url::to(['index']));
$this->params['breadcrumbs'][] =  $model->isNewRecord ? 'Add' : 'Update';;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$formElements = [
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo " 
        [
            'type'=>'text',
            'field'=>'$attribute',
        ],\n";
    }
}


?>
];
echo Yii::$app->controller->renderPartial("@app/views/render-partials/form_elements",compact('model','formElements'));


