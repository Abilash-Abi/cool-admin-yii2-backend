<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$this->title='Reset Password';

?>

<?php 
    $form = ActiveForm::begin(['id' => 'login-form']);
    
    echo $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder'=>'Email Address','class'=>'au-input au-input--full']);
?>
    <div class="form-group">
        <?= Html::submitButton('Send OTP', ['class' => 'au-btn au-btn--block au-btn--green m-b-20', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
     