<?php

namespace app\models\menu;

use wokster\treebehavior\NestedSetsTreeBehavior;
use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property int $left
 * @property int $right
 * @property int $depth
 * @property int $created_at
 * @property int $updated_at
 */
class Menu extends \yii\db\ActiveRecord
{
//    //Понимаем корень или нет
    public $sub_menu;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%folders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            , 'left', 'right', 'depth'
            [['name'], 'required'],
            [[ 'left', 'right', 'depth', 'tree', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['parent_id','sub_menu'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Главный ID',
            'sub_menu'=>'Выбрать назначение',
            'name' => 'Наименование',
            'left' => 'Влево',
            'right' => 'Вправо',
            'depth' => 'Глубина',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',

        ];
    }

    /**
     * {@inheritdoc}
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }


    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function behaviors(){
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                 'leftAttribute' => 'left',
                 'rightAttribute' => 'right',
                 'depthAttribute' => 'depth',
            ],

            'htmlTree'=>[
                'class' => NestedSetsTreeBehavior::className()
            ],



            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],

        ];
    }


//    public function beforeSave($insert)
//    {
//
//        return parent::beforeSave($insert);
//
//    }


}
