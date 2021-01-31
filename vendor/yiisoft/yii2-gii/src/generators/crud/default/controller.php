<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}
/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
$indexUrl = 'index';
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
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
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
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
							'module'=>'',
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
	
		$this->indexUrl = Url::to(['<?=$indexUrl?>']);
		$this->user_id = Yii::$app->user->identity->id;
        return true;
    }
    /**
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $query = <?=$modelClass?>::find();

      
        $query->andFilterWhere(['status'=>Common::param('status')]);
        $query->andFilterWhere(['LIKE','search',Common::param('search')]);


        if(Common::param('export')){
			$filterQuery = clone $query;
			$this->export($filterQuery->all());
        }

        
        return $this->render('index', [
            'posts' => $query,
        ]);
<?php endif; ?>
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
			Common::excelExport($headings,$res,['file'=>'<?=$modelClass?>','excelName'=>'<?=$modelClass?>']);		
		}else{
			CommonHtml::flashError('exportError');
		}
	}

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the previous page.
     * @return mixed
     */
    public function actionCreate(){			
        $model   =  new <?=$modelClass?>();
        if ($model->load(Yii::$app->request->post()) && $model->save<?=$modelClass?>() ) {
				CommonHtml::flashSuccess('<?=lcfirst($modelClass)?>Create',['name'=>$model->name]);
				 return $this->redirect($this->returnUrl);
		}        
        return $this->render('_form',[MODEL=>$model]);
	}

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        <?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
		$model = Db::getModel(<?=$modelClass?>::class,['id'=><?=$condition?>]);

        if ($model->load(Yii::$app->request->post()) && $model->save<?=$modelClass?>() ) {
				CommonHtml::flashSuccess('<?=lcfirst($modelClass)?>Update',['name'=>$model->name]);
				 return $this->redirect($this->returnUrl);
		}   

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the previous page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws data not found error msg if the model cannot be found
     */
    public function actionDelete(<?= $actionParams ?>)
    {
    <?php
        if (count($pks) === 1) {
            $condition = '$id';
        } else {
            $condition = [];
            foreach ($pks as $pk) {
                $condition[] = "'$pk' => \$$pk";
            }
            $condition = '[' . implode(', ', $condition) . ']';
        }
    ?>
        $model = Db::getModel(<?=$modelClass?>::class,['id'=><?=$condition?>]);

	    if($model->delete()){
			CommonHtml::flashSuccess('<?=lcfirst($modelClass)?>Delete',['name'=>$model->name]);
		}
		return $this->redirect($this->returnUrl);   
    }

   
}
