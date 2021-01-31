<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $status
 * @property string|null $created_on
 * @property int|null $created_by
 * @property string|null $created_ip
 * @property string|null $modified_on
 * @property int|null $modified_by
 * @property string|null $modified_ip
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_on',
                'updatedAtAttribute' => 'modified_on',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
                $this->modified_by = Yii::$app->user->getId();
                $this->modified_ip = Yii::$app->getRequest()->getUserIP();	
            if ($this->isNewRecord) {
                $this->created_by = Yii::$app->user->getId();
                $this->created_ip = Yii::$app->getRequest()->getUserIP();
               
            }
            return true;
        }
        return false;
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            ['name','unique'],
            ['name','match','pattern'=>REGX_NAME,'message'=>MSG_NAME],

            [['created_on', 'modified_on'], 'safe'],
            [['created_by', 'modified_by'], 'integer'],
            [['name', 'status'], 'string', 'max' => 20],
            [['created_ip', 'modified_ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'modified_on' => 'Modified On',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
        ];
    }


/**
    *Validate And save Model
 */
 public function saveCategory() {
     if(!$this->validate()){
         return false;
     }
     return $this->save();
 }
}
