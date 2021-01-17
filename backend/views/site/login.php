<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
    $form = ActiveForm::begin(['id' => 'login-form']);
    
    echo $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'Email Address','class'=>'au-input au-input--full']);
    echo $form->field($model, 'password')->passwordInput(['class'=>'au-input au-input--full','placeholder'=>'Password']);
?>
    <div class="login-checkbox">
        <?= $form->field($model, 'rememberMe',['options'=>['class'=>'login-checkbox']])->checkbox() ?>   
        <label><?= Html::a('Forgotten Password?',['site/request-password-reset'])?></label>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'au-btn au-btn--block au-btn--green m-b-20', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
     