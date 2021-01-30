<?php

namespace common\models;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\helpers\Url;
/**
 * This is the model class for table "admin_role_permissions".
 *
 * @property int $id
 * @property int $role_id
 * @property string $permissions
 * @property string $created_on
 * @property int $created_by
 * @property string $created_ip
 * @property string $modified_on
 * @property int $modified_by
 * @property string $modified_ip
 * @property string $status
 *
 * @property AdminRoles $role
 */
class AdminRolePermissions extends \yii\db\ActiveRecord
{
    const ROLE_ID = 'role_id';
    const PERMISSIONS = 'permissions';
    const CREATED_ON = 'created_on';
    const MODIFIED_ON = 'modified_on';
    const CREATED_BY = 'created_by';
    const CREATED_IP = 'created_ip';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => self::CREATED_ON,
                'updatedAtAttribute' => self::MODIFIED_ON,
                'value' => new Expression('NOW()'),
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_role_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[self::ROLE_ID, self::PERMISSIONS, self::CREATED_ON, self::CREATED_BY, self::CREATED_IP], 'required'],
            [[self::ROLE_ID, self::CREATED_BY, 'modified_by'], 'integer'],
            [[self::CREATED_ON, 'modified_on'], 'safe'],
            [[self::CREATED_IP, 'modified_ip'], 'string', 'max' => 20],
            [[self::ROLE_ID], 'exist', 'skipOnError' => true, 'targetClass' => AdminRoles::className(), 'targetAttribute' => [self::ROLE_ID => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            self::ROLE_ID => 'Role',
            self::PERMISSIONS => 'Permissions',
            self::CREATED_ON => 'Created On',
            self::CREATED_BY => 'Created By',
            self::CREATED_IP => 'Created Ip',
            'modified_on' => 'Modified On',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(AdminRoles::className(), ['id' => self::ROLE_ID]);
    }
    /**
     * Update Role Permissions
     */
    public function updateRolePermissions($sendMail=true)
    {
   
        $this->save(false);
        if($sendMail==true){
            // $this->actionSendNotificationToAdmin($this);
        }
        return $this;
    }

    public function actionSendNotificationToAdmin($model)
    {

        $message                = Yii::t(APP_CONTENTS,'adminRolePrivilageAddContent',['name'=>$model->role->role_name]); 
        
        $identifier             = 'Admin Notifications';
        $action                 = MANAGE_USER_ROLES;
        $permission             = 'edit';
        $notificationType       = 'Admin Role Privileges';

        $fullLink 			    = Url::toRoute(['user-roles/privileges','id'=>$model->role->id],true);			
		$link 				    = Url::to(['user-roles/privileges','id'=>$model->role->id]);
        $notificationParams = [
                                'title' => Yii::t(APP_CONTENTS,'adminRolePrivilageAddTitle',['name'=>$model->role->role_name]),
                                'subject' => Yii::t(APP_CONTENTS,'adminRolePrivilageAddSubject',['name'=>$model->role->role_name]), 
                                'messageType' => $notificationType,
                                'link' => $link,
                                'fullLink'		=> $fullLink,
								'buttonLabel'	=> 'Click Here',
                                'mailContent' => $message, 
                                'description' => Yii::t(APP_CONTENTS,'adminRolePrivilageAddTitle',['name'=>$model->role->role_name]),
                            ];
                            
        Yii::$app->commonnotifications->sendAdminNotifications($identifier, $action, $permission,$notificationType, $notificationParams);
        return $model;
    }
}
