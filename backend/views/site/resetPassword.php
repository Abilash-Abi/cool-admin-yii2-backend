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
    
    echo $form->field($model, 'password')->passwordInput(['autofocus' => true,'placeholder'=>'Passsword','class'=>'au-input au-input--full']);
    echo $form->field($model, 're_password')->passwordInput(['autofocus' => true,'placeholder'=>'Passsword','class'=>'au-input au-input--full']);

?>
      

    <div class="form-group">
        <?= Html::submitButton('Reset Password', ['class' => 'au-btn au-btn--block au-btn--green m-b-20', 'name' => 'login-button']) ?>
    </div>
    <label><?= Html::a('Back to login',['site/login'])?></label>
<?php ActiveForm::end(); ?>
     