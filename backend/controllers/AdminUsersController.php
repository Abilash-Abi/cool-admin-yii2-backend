<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
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

class AdminUsersController extends Controller
{
	public $roleNames;
    public function behaviors()
    {
		
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    
                    [
                        ACTIONS => ['index','create','update','delete','export'],
                        'allow' => true,
                        'roles'  => ['@'],
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
										]
				],
			],
           
        ];
    }

    public function beforeAction($action){
        if (!parent::beforeAction($action)) {
            return false;
		}
	
		$this->indexUrl = Url::to(['admin-users/index']);
		$this->user_id = Yii::$app->user->identity->id;
		$rolesArr = AdminRoles::getRolesHideList(HIDE_ROLE_LIST);	
		$this->roleNames = ArrayHelper::map($rolesArr,'id','role_name');
        return true;
    }


    public function actionIndex($search='',$status='', $role='',$export='')
    {
        $filterDesc = "";
        $search = trim($search);
		$query = AdminUsers::find()->joinWith(['adminRole'])
								   ->where(['NOT IN','role_name',HIDE_ROLE_LIST])
								   ->orderBy("id DESC");
		if($search !=""){
			$query->andFilterWhere(['or',['like', 'role_name', $search],['like', 'name', $search],['like', 'email', $search],['like', 'mobile', $search]]);
			$filterDesc .= $filterDesc == "" ? " : ".$search : " | ".$search;
		}					  
		if($status !=""){
			$query->andWhere(['admin_users.status' => $status]);
			$filterDesc .= $filterDesc == "" ? " : ".$status : " | ".$status;
		}	
		if($role !=""){
			$query->andWhere([ADMIN_ROLES_NAME => $role]);
			$filterDesc .= $filterDesc == "" ? " : ".$role : " | ".$role;
		}			
		$rolesArr = AdminRoles::getRolesHideList(HIDE_ROLE_LIST);	
		$countQuery = clone $query;
		

		if($export){
			$filterQuery = clone $query;
			$this->export($filterQuery->all());
		}

		return $this->render('index', [
			 'posts' => $query,
			 'filterDesc' => $filterDesc
		]);
    }


	public function export($model){
		$res = $headings =[];
		if(!empty($model)){
			$slNo=0;
			foreach($model as $modelObject){
				$data['#'] = ++$slNo;
				$data['Name'] = $modelObject->name;
				$data['Email'] = $modelObject->email;
				$data['Role'] = $modelObject->adminRole->role_name;
				$data['Status'] = $modelObject->status;


				$res[]=$data;
			}
			$headings = array_keys($res[0]);
			Common::excelExport($headings,$res,['file'=>'Admin_Users','excelName'=>'Admin Users']);		
		}else{
			CommonHtml::flashError('exportError');

		}
	}

    /**
	 * Create Admin Users
	 */
	public function actionCreate(){			
        $model   =  new AdminUsers();
        if ($model->load(Yii::$app->request->post()) ) {
			
			if($model->validate() && $model->createAdminUser()){
				CommonHtml::flashSuccess('adminUserCreate',['name'=>$model->name]);
				 return $this->redirect($this->returnUrl);
			}
		}        
        return $this->render('form',[MODEL=>$model]);
	}

	//Update Admin user
	public function actionUpdate($id=0){			
		$model = Db::getModel(AdminUsers::class,['id'=>$id]);
        if ($model->load(Yii::$app->request->post()) ) {			
			if($model->save()){
				CommonHtml::flashSuccess('adminUserUpdate',['name'=>$model->name]);
				 return $this->redirect($this->returnUrl);
			}
		}        
        return $this->render('form',[MODEL=>$model]);
	}

	/**
	 * Delelet Admin user
	 */
	public function actionDelete($id=0){
		$model = Db::getModel(AdminUsers::class,['id'=>$id]);
		if($model->delete()){
			CommonHtml::flashSuccess('adminUserDelete',['name'=>$model->name]);
		}
		return $this->redirect($this->returnUrl);
	}

}
