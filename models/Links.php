<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use app\models\LinkType;

class Links extends ActiveRecord
{

	public static function tableName()
    {
        return '{{%links}}';
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

    public function getLinkType(){
        return $this->hasOne(LinkType::className(),[ 'id' => 'link_type' ]);
    }
}

?>
