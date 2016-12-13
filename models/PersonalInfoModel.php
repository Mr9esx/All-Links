<?php

namespace app\models;

use Yii;
use \yii\base\Model;
use app\models\User;
use app\models\PersonalInfo;
use app\models\City;
use yii\web\UploadedFile;

class PersonalInfoModel extends Model
{

    public $uid;
    public $nickname;
    public $sex;
    public $parent_city;
    public $son_city;
    public $relationship_status;
    public $date_of_birth;
    public $mood;
    public $user_logo;
    public $education;
    public $description;

    /*user_logo*/
    public $file;
    public $x;
    public $y;
    public $height;
    public $width;
    public $lastPhoto;

    public function scenarios()
	{
	    return [
	        'updatePersonalInfo' => [ 'uid' , 'sex' , 'parent_city' , 'son_city' , 'relationship_status' , 'date_of_birth' , 'mood' , 'education' , 'nickname' ],
			'updateDescription' => [ 'description' ],
			'updateUserLogo' => [ 'user_logo' , 'file' , 'x' , 'y' , 'height' , 'width' , 'lastPhoto' ]
	    ];
	}

    public function rules()
    {
        return [
            [ 'sex' , 'integer' , 'min' => 0 , 'max' => 2 , 'message' => '非法输入' , 'on' => 'updatePersonalInfo' ],
            [ 'education' , 'integer' , 'min' => 0 , 'max' => 7 , 'message' => '非法输入' , 'on' => 'updatePersonalInfo' ],
            [ 'relationship_status' , 'integer' , 'min' => 0 , 'max' => 2 , 'message' => '非法输入' , 'on' => 'updatePersonalInfo' ],
            [ 'date_of_birth' , 'validateDateOfBirth' , 'on' => 'updatePersonalInfo' ],
            [ 'parent_city' , 'validateParentCity' , 'on' => 'updatePersonalInfo' ],
            [ 'son_city' , 'validateSonCity' , 'on' => 'updatePersonalInfo' ],
            [ 'mood' , 'string' , 'max' => '50' , 'tooLong' => '字数请控制在五十字以内！' , 'on' => 'updatePersonalInfo' ],
            [ 'description' , 'string' , 'on' => 'updateDescription' ],
            [ 'uid' , 'integer' , 'on' => 'updatePersonalInfo' ],
            [ 'lastPhoto' , 'string' ],
            [ [ 'x' , 'y' , 'height' , 'width' ] , 'integer' ],
            [ 'height' , 'heightEqualWidth' ],
            [ 'file' , 'image' , 'extensions' => 'jpg,png,jpeg' , 'mimeTypes' => 'image/jpeg, image/png, image/gif, image/pjpeg' , 'message' => '仅支持 jpg、png、jpeg 格式' ],
            [ 'file' , 'image' , 'maxSize' => 307200 , 'tooBig' => '图片大于 3M ！' ],
            [ 'file' , 'image' , 'minWidth' => 128 , 'minHeight' => 128 , 'underWidth' => '宽度低于 128px ！' , 'underHeight' => '高度低于 128px ！' ],
            [ 'nickname' , 'filter' , 'filter' => 'trim' , 'on' => 'updatePersonalInfo' ],
            [ 'nickname' , 'required' , 'message' => '昵称不能为空!' , 'on' => 'updatePersonalInfo' ],
            [
				'nickname' ,
				'string' ,
				'min' => 5 ,
				'max' => 32 ,
				'tooShort' => '昵称长度不得低于 5 个字符' ,
				'tooLong' => '昵称长度不得超过 32 个字符' ,
				'message' => '昵称长度请在 6 ~ 32 个字符之间' ,
				'on' => [ 'register' , 'updatePersonalInfo' ]
			],
        ];
    }

    /**
	 * 检查用户是否已注册
	 * @param  [type] $attribute [description]
	 * @param  [type] $params    [description]
	 * @return [type]            [description]
	 */
	public function validateUser($attribute, $params)
	{
	    // hasErrors方法，用于获取rule失败的数据
	    if (!$this->hasErrors() && $this->hasUser($this->username)) {
	        $this->addError($attribute, '用户已存在！');
	    }
	}

	/**
     * 检查数据库内是否已存在该用户
     * @param  [type]  $username [description]
     * @return boolean           [description]
     */
	public function hasUser($username){
		return User::findOne( [ 'username' => $username ] ) ? true : false ;
	}

	/**
	 * 检查邮箱是否已注册
	 * @param  [type] $attribute [description]
	 * @param  [type] $params    [description]
	 * @return [type]            [description]
	 */
	public function validateEmail($attribute, $params){
		if (!$this->hasErrors() && $this->hasEmail($this->email)) {
	        $this->addError($attribute, '邮箱已存在！');
	    }
	}

	/**
     * 检查数据库内是否已存在该邮箱
     * @param  [type]  $email [description]
     * @return boolean           [description]
     */
	public function hasEmail($email){
		 return User::findOne( [ 'email' => $email ] ) ? true : false ;
	}

    public function validateDateOfBirth($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (strtotime($this->date_of_birth) > strtotime(date('Y-m-d')) || substr($this->date_of_birth,0,strpos($this->date_of_birth,'-')) < 1900){
                $this->addError($attribute, 'errors');
            }
	    }
    }

    public function validateParentCity($attribute, $params)
    {
        if (City::findOne( [ 'area_id' => $this->parent_city ] )) {
            return true;
        }
    }

    public function validateSonCity($attribute, $params)
    {
        if (City::findOne( [ 'area_id' => $this->son_city ] )->parent_id === $this->parent_city){
            return true;
        }
    }

    public function savePersonalInfo($uid)
    {

        if ($this->validate()){
            $personal_info = new PersonalInfo();
            $personal_info = $personal_info::findIdentity($uid);
            $personal_info->nickname = $this->nickname;
            $personal_info->sex = $this->sex;
            $personal_info->mood = nl2br($this->mood);
            $personal_info->date_of_birth = $this->date_of_birth;
            $personal_info->location = $this->parent_city.':'.$this->son_city;
            $personal_info->relationship_status = $this->relationship_status;
            $personal_info->education = $this->education;
            return $personal_info->update(false);
        }

    }

    public function saveDescription($uid){

        if ($this->validate()){

            $user_info = new PersonalInfo();
            $user_info = $user_info::findIdentity($uid);
            $user_info->description = nl2br($this->description);

            if ($user_info->update()){
                return true;
            }

        }

    }

    public function saveUserLogo($url){
        $uid = Yii::$app->user->getId();
        $user_info = new PersonalInfo();
        $user_info = $user_info::findIdentity($uid);
        $user_info->user_logo = $url;
        if ($user_info->update()){
            return true;
        }
    }

    public function heightEqualWidth(){
        if ($this->height === $this->width){
            return true;
        }
    }

}

?>
