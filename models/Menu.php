<?php

namespace heimo\rbac\models;

use heimo\rbac\components\Helper;
use heimo\rbac\helper\RbacHelper;
use Yii;
use heimo\rbac\components\Configs;
use yii\db\Query;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id         Menu id(autoincrement)
 * @property string  $name       Menu name
 * @property integer $parent     Menu parent
 * @property string  $route      Route for this menu
 * @property integer $order      Menu order
 * @property string  $data       Extra information for this menu
 *
 * @property Menu    $menuParent Menu parent
 * @property Menu[]  $menus      Menu children
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since  1.0
 */
class Menu extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Configs::instance()->menuTable;
    }
    
    /**
     * @inheritdoc
     */
    public static function getDb()
    {
        if (Configs::instance()->db !== null) {
            return Configs::instance()->db;
        } else {
            return parent::getDb();
        }
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [
                ['parent_name'],
                'in',
                'range' => static::find()->select(['name'])->column(),
                'message' => 'Menu "{value}" not found.'
            ],
            [['parent', 'route', 'data', 'order'], 'default'],
            [
                ['parent'],
                'filterParent',
                'when' => function () {
                    return !$this->isNewRecord;
                }
            ],
            [['order'], 'integer'],
            [
                ['route'],
                'in',
                'range' => static::getSavedRoutes(),
                'message' => 'Route "{value}" not found.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',//ii::t('rbac-admin', 'ID'),
            'name' => 'name',//Yii::t('rbac-admin', 'Name'),
            'parent' => 'parent',//Yii::t('rbac-admin', 'Parent'),
            'parent_name' => 'parent_name',//Yii::t('rbac-admin', 'Parent Name'),
            'route' => 'route',//Yii::t('rbac-admin', 'Route'),
            'order' => 'order',//Yii::t('rbac-admin', 'Order'),
            'data' => 'data',//Yii::t('rbac-admin', 'Data'),
        ];
    }
}
