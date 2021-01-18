<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\AdminUsers;
use common\models\AdminRoles;
use common\models\AdminRolePermissions;

use yii\data\Pagination; 
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

const REDIRECT_INDEX = 'user-roles/index';
const MSG_ROLEDELETE   = 'roleDelete';

class UserRolesController extends \yii\web\Controller
{
    const ROLES = 'roles';
    const NOT_IN = 'NOT IN';
    const ROLE_NAME = 'role_name';
    public $returnUrl;

   public $hideRoleList = array('Super Admin');
   public $repoArray = array();
   public function behaviors()
    {
		
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    
                    [
                        ACTIONS => ['index','create','update','delete','privileges','update-privileges'],
                        'allow' => true,
                        self::ROLES  => ['@'],
                    ],
                ],
            ],
           
        ];
    }

    public function beforeAction($actions){
        $this->returnUrl =  Yii::$app->request->referrer;
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
    public function actionIndex($search='',$status=''){

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
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>Yii::$app->params['pageLimit']]);
		
		$posts = $query->offset($pages->offset)
			->limit(Yii::$app->params['pageLimit'])
			->all();
		return $this->render('index', [
			 'posts' => $posts,
			 'pages' => $pages,
			 'filterDesc' => $filterDesc
		]);
	}
	/**
	 *Create User Role Page 
	 * view form and add Role
	 */
	public function actionCreate(){
		$this->view->title = "Add User Roles";
		// Yii::$app->permissions->isAllowed(MANAGE_USER_ROLES, 'add');
		
		$model = new AdminRoles;
		$current_user = Yii::$app->user->getId();		
		$model->created_on = date(DB_DATETIME);
        $model->created_by = Yii::$app->user->getId();
        $model->created_ip = Yii::$app->getRequest()->getUserIP();
        $model->modified_on = date(DB_DATETIME);
        $model->modified_by = Yii::$app->user->getId();
        $model->modified_ip = Yii::$app->getRequest()->getUserIP();	
		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveRole()) {		
			Yii::$app->session->setFlash(SUCCESS, Yii::t(USER_ALERETS,'roleCreate',[NAME=>$model->role_name]));
				return $this->redirect($this->returnUrl);		
		}
		
		return $this->render('form',[MODEL=>$model]);
	}

}