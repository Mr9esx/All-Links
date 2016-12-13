<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\PersonalInfo;


class UserModel extends Model
{

	public $uid;
    public $username;
    public $password;
    public $repeat_password;
    public $email;
    public $agree;

	public function scenarios()
	{
	    return [
	        'register' => [ 'username' , 'password' , 'repeat_password' , 'email' , 'agree' ],
			'userAdd' => [ 'username' , 'password' , 'repeat_password' , 'email' ],
	        'updateByAdmin' => [ 'username' ],
			'updateEmail' => [ 'email' ]
	    ];
	}

	public function rules()
	{
		return [
		 	[ 'username' , 'filter' , 'filter' => 'trim' , 'on' => [ 'register' , 'userAdd' , 'updateByAdmin' ] ],
			[ 'password' , 'filter' , 'filter' => 'trim' , 'on' => [ 'register' , 'userAdd' ] ],
		 	[ 'username' , 'required' , 'message' => '用户名不能为空!' , 'on' => [ 'register' , 'userAdd' , 'updateByAdmin' ] ],
		 	[ 'password' , 'required' , 'message' => '密码不能为空！' , 'on' => [ 'register' , 'userAdd' ] ],
		 	[ 'username' , 'validateUser' , 'on' => [ 'register' , 'updateUsername' , 'updateByAdmin' , 'userAdd' ] ],
		 	[ 'email' , 'validateEmail' , 'on' => [ 'register' , 'updateEmail' , 'updateByAdmin' , 'userAdd' ] ],
		 	[ 'repeat_password' , 'required' , 'message' => '两次输入的密码不一致！' , 'on' =>  [ 'register' , 'userAdd' ] ],
		 	[
				'username' ,
				'string' ,
				'min' => 5 ,
				'max' => 32 ,
				'tooShort' =>
				'用户名长度不得低于 5 个字符' ,
				'tooLong' => '用户名长度不得超过 32 个字符' ,
				'message' => '账号长度请在 6 ~ 32 个字符之间' ,
				'on' => [ 'register' , 'updateUsername' , 'userAdd' ]
			],
		 	[
				'password' ,
				'string' ,
				'min' => 6 ,
				'max' => 32 ,
				'tooShort' => '密码长度不得低于 6 个字符' ,
				'tooLong' => '密码长度不得超过 32 个字符' ,
				'message' => '账号长度请在 6 ~ 32 个字符之间',
				'on' => [ 'register' , 'userAdd' ]
			],
		 	[
				'repeat_password' ,
				'compare' ,
				'compareAttribute'=>'password' ,
				'message'=>'两次输入的密码不一致！' ,
				'on' => [ 'register' , 'userAdd' ]
			],
            [ 'email' , 'required' , 'message' => '邮箱不能为空!' , 'on' => [ 'register' , 'updateEmail' , 'userAdd' ] ],
            [ 'email' , 'email' , 'message' => '邮箱格式错误！' , 'on' => [ 'register' , 'updateEmail' , 'userAdd' ] ],
			[ 'agree' , 'required' , 'requiredValue'=> true , 'message'=>'请确认是否同意隐私权协议条款' , 'on' => [ 'register' ] ],
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
	public function hasEmail($email)
	{
		 return User::findOne( [ 'email' => $email ] ) ? true : false ;
	}

	public function register()
    {
    	if ($this->validate()) {
	       	// 实现数据入库操作
	        $user = new User();
	        $user->username = $this->username;
	        $user->email = $this->email;
	        $user->register_at = date('Y-m-d H:i:s',time());
	        $user->last_login_time = date('Y-m-d H:i:s',time());
			// 密码加密
	        $user->setPassword($this->password);
			$user->generateAuthKey();
			$user->generateAccessToken();

	        // 生成 "remember me" 认证key
	        //$user->generateAuthKey();

	        // save(false)的意思是：不调用UserBackend的rules再做校验并实现数据入库操作
	        // 这里这个false如果不加，save底层会调用UserBackend的rules方法再对数据进行一次校验，因为我们上面已经调用Signup的rules校验过了，这里就没必要在用UserBackend的rules校验了
			if ($user->save(false)){
				// 写入用户个人信息
				$uid = $user::find()->where( [ 'username' => $this->username ] )->one()->id;
				$personal_info = new PersonalInfo();
				$personal_info->user_logo = "/images/default-user.png";
				$personal_info->uid = $uid;
				$personal_info->nickname = $this->username;
				return $personal_info->save();
			}else{
				return false;
			}
	    } else {
	        return false;
	    }
    }

	public function saveUsername($uid){

		if ( $this->validate() ){

			$user_info = new User();
            $user_info = $user_info::findIdentity($uid);
			$user_info->username = $this->username;
			return $user_info->update(false);

		}

	}

}
?>
