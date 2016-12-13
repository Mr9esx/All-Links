<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\LinkType;

class LinkModel extends Model
{

	public $id;
	public $link_type;
	public $description;
	public $icon;

	public function scenarios()
	{
	    return [
	        'addLink' => [ 'link_type' , 'description' , 'icon' ],
			'changeLink' => [ 'id' , 'link_type' , 'description' , 'icon' ],
	    ];
	}

	public function rules(){
		return [
			[ 'id' , 'integer' , 'on' => 'changeLink' ],
			[ 'link_type' , 'string' , 'min' => 2 , 'max' => 24 , 'tooShort' => '字数小于 2！' , 'tooLong' => '字数大于 24 ！' , 'on' => [ 'addLink' , 'changeLink' ] ],
			[ 'description' , 'string' , 'on' => [ 'addLink' , 'changeLink' ] ],
			[ 'icon' , 'string' , 'on' => [ 'addLink' , 'changeLink' ] ],
			[ [ 'link_type' , 'icon' , 'description' ] , 'required' , 'on' => [ 'addLink' , 'changeLink' ] , 'message' => '不能为空！' ]
		];
	}

	public function saveLink(){
		if ($this->validate()){
			$links = new LinkType;
			$links->link_type = $this->link_type;
			$links->description = $this->description;
			$links->icon = $this->icon;
			// var_dump($this);
			// exit();
			$links->created_at = date('Y-m-d H:i:s',time());
			if ($links->save(false)){
				return true;
			}
		}
	}


	public function changeLink($id){
		if ($this->validate()){
			$link_type = new LinkType();
            $link_type = $link_type::findIdentity($id);
			$link_type->link_type = $this->link_type;
			$link_type->description = $this->description;
			$link_type->icon = $this->icon;
			if ($link_type->update(false)){
				return true;
			}
		}
	}

}

?>
