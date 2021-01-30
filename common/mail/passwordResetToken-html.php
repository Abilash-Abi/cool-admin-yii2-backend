<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>




        
<div style="Margin-left: 20px;Margin-right: 20px;">
      <div style="mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;">
        <h1 style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;color: #000;font-size: 26px;line-height: 34px;font-family: Times,Times New Roman,serif;text-align: center;">Reset Password</h1>
      </div>
    </div>
        
            <div style="Margin-left: 20px;Margin-right: 20px;">
      <div style="mso-line-height-rule: exactly;line-height: 2px;font-size: 1px;">&nbsp;</div>
    </div>
        
          </div>
        <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
        </div>
      </div>
  
      <div class="layout one-col fixed-width stack" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
        <div class="layout__inner" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;">
        <!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0" role="presentation"><tr class="layout-fixed-width" style="background-color: #ffffff;"><td style="width: 600px" class="w560"><![endif]-->
          <div class="column" style="text-align: left;color: #000;font-size: 16px;line-height: 24px;font-family: Verdana,sans-serif;">
        
            <div style="Margin-left: 20px;Margin-right: 20px;">
      <div style="mso-line-height-rule: exactly;mso-text-raise: 11px;vertical-align: middle;">
        <p style="Margin-top: 0;Margin-bottom: 0;">&nbsp;</p><p style="Margin-top: 20px;Margin-bottom: 0;">Hi <?= Html::encode($user->name) ?>,</p>
        
        <p style="Margin-top: 20px;Margin-bottom: 0;">Your OTP :  <?=Html::encode($user->otp)?></p>
        
        <p style="Margin-top: 20px;Margin-bottom: 20px;">Follow the link below to reset your password:</p>
      </div>
    </div>

    <div style="Margin-left: 20px;Margin-right: 20px;">
      <div class="btn btn--flat btn--large" style="Margin-bottom: 20px;text-align: left;">
       <a style="border-radius: 0;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #000000 !important;background-color: #fdba13;font-family: Times, Times New Roman, serif;" href="<?=$resetLink?>">Change Password</a></div>
    </div>
        
         
        
          </div>
      
        
           
