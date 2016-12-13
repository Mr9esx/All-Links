<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use app\models\Links;

class LinkType extends ActiveRecord
{

	public static function tableName()
    {
        return '{{%link_type}}';
    }

	/**
	 * 根据ID查找链接资料
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public static function findIdentity($id)
	{
		return static::findOne([ 'id' => $id ]);
	}

	public function getLinks(){
        return $this->hasOne(Links::className(),[ 'link_type' => 'id' ]);
    }

}

?>
