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

class AdminUsersController extends \yii\web\Controller
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


    public function actionIndex($search='',$status='', $role='')
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
		$pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>Yii::$app->params['pageLimit']]);
		
		$posts = $query->offset($pages->offset)
			->limit(Yii::$app->params['pageLimit'])
			->all();

		return $this->render('index', [
			 'posts' => $query,
			 'filterDesc' => $filterDesc
		]);
    }


    /**
	 * Create Admin Users
	 */
	public function actionCreate(){			
        $model   =  new AdminUsers();
        if ($model->load(Yii::$app->request->post()) ) {
			
			if($model->validate() && $model->createAdminUser()){
				Yii::$app->session->setFlash(SUCCESS, Yii::t(USER_ALERETS,'userCreate',[NAME=>$model->name]));
				 return $this->redirect($this->returnUrl);
			}
		}        
        return $this->render('form',[MODEL=>$model]);
	}

}
