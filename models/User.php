<?php

namespace app\models;

use Yii;
use \yii\web\IdentityInterface;
use \yii\db\ActiveRecord;
use app\models\PersonalInfo;


class User extends ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        //%自动匹配表前缀（app_register_user）
        return '{{%user}}';
    }


     /**
     * 为model的password_hash字段生成密码的hash值
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }


    /**
     * 检查用户是否已注册
     * @param  [type]  $username [description]
     * @return boolean           [description]
     */
    public function hasUser($username){
        return static::findOne( [ 'username' => $username ] ) ? true : false ;
    }

    /**
     * 生成 "remember me" 认证key
     * @return [type] [description]
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * 生成 accessToken
     * @return [type] [description]
     */
    public function generateAccessToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }

    /**
     * 根据ID查找用户资料
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function findIdentity($id)
    {
        return static::findOne([ 'id' => $id ]);
    }

    /**
     * [findIdentityByAccessToken description]
     * @param  [type] $token [description]
     * @param  [type] $type  [description]
     * @return [type]        [description]
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * 从数据库中查找用户
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getPersonalInfo(){
        return $this->hasOne(PersonalInfo::className(),[ 'uid' => 'id' ]);
    }

    public function getAuth(){
        return $this->hasOne(PersonalInfo::className(),[ 'uid' => 'id' ]);
    }
}
