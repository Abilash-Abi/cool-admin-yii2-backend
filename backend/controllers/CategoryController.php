<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
  
use yii\filters\AccessControl;
use common\components\PermissionControl;

use yii\data\Pagination; 
use yii\helpers\Url;
use common\libraries\CommonHtml;
use common\libraries\Common;
use common\libraries\Db;
use yii\helpers\ArrayHelper;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    public $permissionModule;
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
							'module'=>MANAGE_CATEGORY,
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
        $this->permissionModule = MANAGE_CATEGORY;
		$this->indexUrl = Url::to(['index']);
		$this->user_id = Yii::$app->user->identity->id;
        return true;
    }
    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Category::find();

      
        $query->andFilterWhere(['status'=>Common::param('status')]);
        $query->andFilterWhere(['LIKE','name',Common::param('search')]);


        if(Common::param('export')){
			$filterQuery = clone $query;
			$this->export($filterQuery->all());
        }

        
        return $this->render('index', [
            'posts' => $query,
        ]);
    }

    /**
    * Export listing data as excel 
     */
    public function export($model){
		$res = $headings =[];
		if(!empty($model)){
			$slNo=0;
			foreach($model as $modelObject){
				$data['#'] = ++$slNo;
				$res[]=$data;
			}
			$headings = array_keys($res[0]);
			Common::excelExport($headings,$res,['file'=>'Category','excelName'=>'Category']);		
		}else{
			CommonHtml::flashError('exportError');
		}
	}

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the previous page.
     * @return mixed
     */
    public function actionCreate(){			
        $model   =  new Category();
        if ($model->load(Yii::$app->request->post()) && $model->saveCategory() ) {
				CommonHtml::flashSuccess('categoryCreate',['name'=>$model->name]);
				 return $this->redirect($this->returnUrl);
		}        
        return $this->render('_form',[MODEL=>$model]);
	}

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Db::getModel(Category::class,['id'=>$id]);

        if ($model->load(Yii::$app->request->post()) && $model->saveCategory() ) {
				CommonHtml::flashSuccess('categoryUpdate',['name'=>$model->name]);
				 return $this->redirect($this->returnUrl);
		}   

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the previous page.
     * @param integer $id
     * @return mixed
     * @throws data not found error msg if the model cannot be found
     */
    public function actionDelete($id)
    {
            $model = Db::getModel(Category::class,['id'=>$id]);

	    if($model->delete()){
			CommonHtml::flashSuccess('categoryDelete',['name'=>$model->name]);
		}
		return $this->redirect($this->returnUrl);   
    }

   
}
