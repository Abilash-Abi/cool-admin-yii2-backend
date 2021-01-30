<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\AdminUsers;
use common\components\BackendEmails;
/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\AdminUsers',
                'filter' => ['status' => AdminUsers::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user AdminUsers */
        $user = AdminUsers::findOne([
            'status' => AdminUsers::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!AdminUsers::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
           
            if (!$user->save()) {
                return false;
            }
        }


         Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

            return $user->password_reset_token;
    }

     /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function createResetOTP()
    {
        /* @var $user User */
        $user = AdminUsers::findOne([
            'status' => AdminUsers::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
        if (!$user) {
            return false;
        }
        
        $user->otp            = mt_rand(100000, 999999);
        $user->reset_otp_expired_on = date("Y-m-d H:i:s", strtotime('+3 minutes'));
        $user->generatePasswordResetToken();;    
        if (!$user->save(false)) {
          return false;
        } 
        $this->sendMail($user);  
        return $user->password_reset_token;
      
    }
    /**
     * Send forgot password OTP and Reset Link to User
     */
    public function sendMail($user) {
        return BackendEmails::adminForgotPassword($user);
    }
}
