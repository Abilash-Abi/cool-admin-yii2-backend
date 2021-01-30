<?php
namespace common\components;
use Yii;
use common\models\AdminRolePermissions;
use yii\helpers\Url;
use yii\base\Behavior;
use yii\web\UnauthorizedHttpException;
class PermissionControl extends Behavior {

    


    public $module;
    public $actions;
    public $permissions;
    public $returnUrl;
    public $user_id;
    public $indexUrl;
    public $rules;
    // public function events()
    // {
    //     return [
    //         ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
    //     ];
    // }

    public function beforeValidate($event)
    {
        print_r($event);
        die;
    }
    // public function __construct($action){
   
    //     $userId = Yii::$app->user->identity->id;
    //     $this->returnUrl =  Yii::$app->request->referrer;
	// 	$this->indexUrl = Url::to(['user-roles/index']);
    //     $this->user_id = Yii::$app->user->identity->id;
        
    //     $this->permissions = Yii::$app->session[$userId.'_permissions'];
    //     $this->module   = $actions['rules']['module'];
    //     $this->actions = $actions['rules']['actions'];
        
    //     $this->getPermission();
    // }

    public function getPermission(){
        $userId = Yii::$app->user->identity->id;
        if(empty($this->permissions)){
            $role_id =  Yii::$app->user->identity->adminRole->id;
            $model = AdminRolePermissions::find()->where(['role_id'=>$role_id])->one();
			$permissions = json_decode($model->permissions,true);
            Yii::$app->session[$userId.'_permissions'] = $permissions;
            $this->permissions =  $permissions;
            $model->permissions;
        }
        $this->checkPermision();
    }

    public function checkPermision() {
        if(!$this->validatePermission()){
            throw new UnauthorizedHttpException('You are not allowed to view this page.');
        }
    }

    public function validatePermission(){
        $roleName = Yii::$app->user->identity->adminRole->role_name;
        if($roleName==SUPER_ADMIN){
            return true;
        }
        $actionFunction = Yii::$app->controller->action->id;
        if(!empty($this->actions[$actionFunction]) && !empty($this->permissions[$this->module])) { //Check the action url exist in the rules
            $ruleAction = $this->actions[$actionFunction]; //eg : add,edit,delete ...
                if(in_array($ruleAction,$this->permissions[$this->module])){
                    return true;
                }
        }
        return false;
    }


    public static function isAllowed($module,$action){
        $userId = Yii::$app->user->identity->id;
        $roleName = Yii::$app->user->identity->adminRole->role_name;
        if($roleName==SUPER_ADMIN) {
            return true;
        }
        $permissions =  Yii::$app->session[$userId.'_permissions'];
        if(in_array($action,$permissions[$module])){
            return true;
        }
      return false;
    }

}