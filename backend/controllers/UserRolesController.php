<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\PermissionControl;

use common\models\AdminUsers;
use common\models\AdminRoles;
use common\models\AdminRolePermissions;

use yii\data\Pagination; 
use yii\helpers\Url;
use common\libraries\CommonHtml;
use common\libraries\Common;
use common\libraries\Db;
use yii\helpers\ArrayHelper;

const REDIRECT_INDEX = 'user-roles/index';
const MSG_ROLEDELETE   = 'roleDelete';

class UserRolesController extends \yii\web\Controller
{
    const ROLES = 'roles';
    const NOT_IN = 'NOT IN';
    const ROLE_NAME = 'role_name';
	public $returnUrl;
	public $indexUrl;
	public $rolePermissions;
	public $user_id;

   public $hideRoleList = array('Super Admin');
   public $repoArray = array();
   public function behaviors()
    {
		
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    
                    [
                        ACTIONS => ['index','create','update','delete','privileges','update-privileges','export'],
                        'allow' => true,
                        self::ROLES  => ['@'],
                    ],
                ],
			],
			'permission' =>[
				'class'=>PermissionControl::className(),
				'rules'=>[
							'module'=>MANAGE_USER_ROLES,
							'actions'=>[
											'index'=>'view',
											'create'=>'add',
											'update'=>'edit',
											'delete'=>'add',
											'privileges'=>'view',
											'update-privileges'=>'add',
										]
				],
			],
           
        ];
    }

    public function beforeAction($action){
		if (!parent::beforeAction($action)) {
			return false;
		}
	
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            ERROR => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
	}
	/**
	 * Display User Roles Page
	 */
    public function actionIndex($search='',$status='',$export=0){

		$search = trim($search);
        $filterDesc = "";
     
		// Yii::$app->permissions->isAllowed(MANAGE_USER_ROLES, 'view');				
		$query = AdminRoles::find()->where([self::NOT_IN,self::ROLE_NAME,$this->hideRoleList])
							  ->orderBy("id DESC");
		if($search !=""){
			$query->andFilterWhere(['or',['like', self::ROLE_NAME, $search]]);
			$filterDesc .= $filterDesc == "" ? " : ".$search : " | ".$search;
		}					  
		if($status !=""){
			$query->andWhere(['status' => $status]);
			$filterDesc .= $filterDesc == "" ? " : ".$status : " | ".$status;
		}	 
		
		if($export){
			$filterQuery = clone $query;
			$this->export($filterQuery->all());
		}
		$countQuery = clone $query;

			return $this->render('index', [
			 'posts' => $query,
			 'filterDesc' => $filterDesc
		]);
	}
	
	//************** //Add User Role *************/
	public function actionCreate(){
		$this->view->title = "Add User Roles";
		// Yii::$app->permissions->isAllowed(MANAGE_USER_ROLES, 'add');
		
		$model = new AdminRoles;

        $model->created_by = Yii::$app->user->getId();
        $model->created_ip = Yii::$app->getRequest()->getUserIP();
        $model->modified_by = Yii::$app->user->getId();
		$model->modified_ip = Yii::$app->getRequest()->getUserIP();	
        $model->status = 'Active';	
		
		if ($model->load(Yii::$app->request->post()) && $model->saveRole()) {		
				CommonHtml::flashSuccess('roleCreate',['name'=>$model->role_name]);
				return $this->redirect($this->returnUrl);		
		}
		
		return $this->render('form',[MODEL=>$model]);
	}
	//************** //Add User Role *************/


	//************** Update User Role *************/
	public function actionUpdate($id=0){
		// Yii::$app->permissions->isAllowed(MANAGE_USER_ROLES, 'add');		
		$model = AdminRoles::find()->where(['id'=>$id])->one();

        $model->created_by = Yii::$app->user->getId();
        $model->created_ip = Yii::$app->getRequest()->getUserIP();
        $model->modified_by = Yii::$app->user->getId();
		$model->modified_ip = Yii::$app->getRequest()->getUserIP();	
        $model->status = 'Active';	
		
		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveRole()) {		
			CommonHtml::flashSuccess('roleUpdate',['name'=>$model->role_name]);
				return $this->redirect($this->returnUrl);		
		}
		
		return $this->render('form',[MODEL=>$model]);
	}
	//************** //Update User Role *************/

	//**************** Delete User Role **************/
	public function actionDelete($id){
		$model = Db::getModel(AdminRoles::class,['id'=>$id]);
		if($model->delete()){
			CommonHtml::flashSuccess('roleDelete',['name'=>$model->role_name]);
		}
		return $this->redirect($this->returnUrl);

	}
	//************** //Delete User Role *************/

	public function export($model){
		$res = $headings =[];
		if(!empty($model)){
			$slNo=0;
			foreach($model as $modelObject){
				$data['#'] = ++$slNo;
				$data['Role Name'] = $modelObject->role_name;
				$data['Status'] = $modelObject->status;
				$res[]=$data;
			}
			$headings = array_keys($res[0]);
			Common::excelExport($headings,$res,['file'=>'User Roles','excelName'=>'User Roles']);		
		}else{
			CommonHtml::flashError('exportError');

		}
		
	}


	/******************  Role Privileges ****************/
	/**
	 * View Previleges Of role
	 *  
	  */
	  public function actionPrivileges($id = 0){  
		$current_user = Yii::$app->user->getId();		
		$role= AdminRoles::find()->where(['Id' => $id])
							 ->andWhere(['not in','role_name',$this->hideRoleList])
							 ->one();
		if(!empty($role)){
			$model = AdminRolePermissions::find()->where(['role_id' => $role->id])->one();
            empty($model) ? $model = new AdminRolePermissions : "";
            $model->role_id = $role->id;
			$permissions = !empty($model) ? json_decode($model->permissions,true) : array();
			$this->rolePermissions = $permissions;
			
			return $this->render("viewPermission", [MODEL=>$model]);
		}else{
			CommonHtml::flashError(SELECTED_DATA_DOES_NOT_EXIST,['name'=>$model->role_name]);

				return $this->redirect($returnUrl);
		}
	}

	/******************  //Role Privileges ****************/

	/****************  Update Role Privileges ***********/
	public function actionUpdatePrivileges($id = 0){

		$current_user = Yii::$app->user->getId();		
		$role= AdminRoles::find()->where(['Id' => $id])
							 ->andWhere(['not in','role_name',$this->hideRoleList])
							 ->one();
		if(!empty($role)){
			$model = AdminRolePermissions::find()->where(['role_id' => $role->id])->one();
			if(empty($model)) {
				$model = new AdminRolePermissions;
			}
          
			if (Yii::$app->request->post()) {	
				$model->role_id = $role->id;
				$model->created_ip = Yii::$app->getRequest()->getUserIP();

				$model->created_by = $this->user_id;				
				$model->modified_by = Yii::$app->user->getId();
				$model->modified_ip = Yii::$app->getRequest()->getUserIP();	
				$model->permissions = !empty($_POST['RolePermissions']['permissions']) ? json_encode($_POST['RolePermissions']['permissions']) : "";
				if($model->updateRolePermissions()){
					CommonHtml::flashSuccess('privileges');
					
					return $this->redirect(Url::to(['user-roles/index']));
				}
			}

			$permissions = !empty($model) ? json_decode($model->permissions,true) : array();

			$this->rolePermissions = $permissions;

			return $this->render("formPermission", [MODEL=>$model]);
		}
	}

	/****************  //Update Role Privileges ***********/




}