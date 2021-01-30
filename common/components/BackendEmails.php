<?php
namespace common\components;
use Yii;

class BackendEmails {
	const MESSAGE  = 'message';
    const USERNAME ='username';
    const EMAILS   = 'emails';
   
    
	public static function adminLoginCredentials($emails,$username, $password, $name, $type) {
		$loginUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
			$emails = (array) $emails;
			
			if(empty($emails)){
				return;
			}
		if ($type == 'create') {
			$subject = Yii::t(APP_CONTENTS,'createUserSubject');
			$message = Yii::t(APP_CONTENTS,'createUserContent'); 
				
			$mailer = Yii::$app->mailer->compose('@common/mail/admin/admin-user-credentials', ['name'=>$name,self::MESSAGE=>$message,self::USERNAME=>$username,'password'=>$password,'loginUrl'=>$loginUrl])
							->setFrom(NO_REPLAY_MAIL);
			$mailer->setTo($emails);			 
			$mailer->setSubject($subject)->send();
		} else if ($type == 'passwordchanged') {
			$subject = Yii::t(APP_CONTENTS,'UserPswdUpdateSubject'); 
			$message = Yii::t(APP_CONTENTS,'UserPswdUpdateContent'); 
				
			$mailer = Yii::$app->mailer->compose('@common/mail/admin/admin-user-credentials', ['name'=>$name,self::MESSAGE=>$message,self::USERNAME=>$username,'password'=>$password,'loginUrl'=>$loginUrl])
						->setFrom(NO_REPLAY_MAIL);
			$mailer->setTo($emails);			 
			$mailer->setSubject($subject)->send();
		}
	}
	//Forgot Password 
	public static function adminForgotPassword($user) 
	{
		$subject = Yii::t(APP_CONTENTS,'ForgetPasswordSubject');
		 $mail =   Yii::$app
        ->mailer
        ->compose(
            ['html' => '@common/mail/passwordResetToken-html'],
            ['user' => $user]
        )
        ->setFrom(NO_REPLAY_MAIL)
        ->setTo($user->email)
        ->setSubject($subject)
        ->send();
        if ($mail) {
        return $user;
        }
        return false;
    }	
	
}
