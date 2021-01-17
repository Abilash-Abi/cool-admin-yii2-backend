
<?php if (Yii::$app->session->hasFlash('success')): ?>

<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
<?= Yii::$app->session->getFlash('success') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>

<?php 
endif; 
    if (Yii::$app->session->hasFlash('error')):
     ?>
 
<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
<?= Yii::$app->session->getFlash('error') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>    
<?php endif; ?>