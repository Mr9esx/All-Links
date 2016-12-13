<?php

	namespace app\models;

	use Yii;
	use yii\base\Model;

	use app\models\RegisterUser;
	use app\models\User;

	class LoginForm extends Model
	{

	    public $username;
	    public $password;
	    public $rememberMe;
	    public $_user;

		/*用于验证*/
		public function rules()
		{
			return [
			 	[ 'username' , 'filter' , 'filter' => 'trim' ],
			 	[ 'password' , 'filter' , 'filter' => 'trim' ],
			 	[ 'username' , 'required' , 'message' => '用户名不能为空!' ],
			 	[ 'password' , 'required' , 'message' => '密码不能为空！' ],
			 	[ 'username' , 'validateUsername'],
			 	[ 'password' , 'validatePassword'],
			 	/*[ 'password' , 'checkPassword' , 'skipOnEmpty' => false ],*/
			 	[ 'username' , 'string', 'min' => 5 , 'max' => 32 , 'tooShort' => '用户名长度不得少于 5 个字符' , 'tooLong' => '用户名长度不得超过 32 个字符' , 'message' => '账号长度请在 6 ~ 32 个字符之间' ],
			 	[ 'password' , 'string', 'min' => 6 , 'max' => 32 , 'tooShort' => '密码长度不得少于 6 个字符' , 'tooLong' => '密码长度不得超过 32 个字符' , 'message' => '账号长度请在 6 ~ 32 个字符之间' ],
			 	[ 'rememberMe' , 'boolean']
	        ];
		}

		public function validatePassword($attribute, $params)
		{
		    // hasErrors方法，用于获取rule失败的数据
		    if (!$this->hasErrors()) {
		        // 调用当前模型的getUser方法获取用户
		        $user = $this->getUser();
		        // 获取到用户信息，然后校验用户的密码对不对，校验密码调用的是 backend\models\UserBackend 的validatePassword方法，
		        // 这个我们下面会在UserBackend方法里增加
		        if (!$user || !$user->validatePassword($this->password)) {
		            // 验证失败，调用addError方法给用户提醒信息
		            $this->addError($attribute, '密码错误！');
		        }
		    }
		}

		public function validateUsername($attribute, $params)
		{
		    // hasErrors方法，用于获取rule失败的数据
		    if (!$this->hasErrors()) {
		        // 调用当前模型的getUser方法获取用户
		        $user = $this->getUser();
		        // 获取到用户信息，然后校验用户的密码对不对，校验密码调用的是 backend\models\UserBackend 的validatePassword方法，
		        // 这个我们下面会在UserBackend方法里增加
		        if ($user === null) {
		            // 验证失败，调用addError方法给用户提醒信息
		            $this->addError($attribute, '用户名错误！');
		        }
		    }
		}

		public function getUser(){
			if ($this->_user === null) {
		        // 根据用户名 调用认证类 backend\models\UserBackend 的 findByUsername 获取用户认证信息
		        // 这个我们下面会在UserBackend增加一个findByUsername方法对其实现
		        $this->_user = User::findByUsername($this->username);
		    }
    		return $this->_user;
		}

		public function login()
		{
		    // 调用validate方法 进行rule的校验，其中包括用户是否存在和密码是否正确的校验

		    if ($this->validate() && Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 3 : 0)) {
		    	//执行validate开始检验，执行validateUsername和validatePassword
		    	//如果其中一个出错则addError
		        // 校验成功后，session保存用户信息
				$user = new User();
				$user = $user::findIdentity(Yii::$app->user->getIdentity()->id);
				$user->last_login_time = date('Y-m-d H:i:s',time());
				if ($user->update()){
					return true;
				}
		    } else {
		        return false;
		    }
		}

	}

?>
