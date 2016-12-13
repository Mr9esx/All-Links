<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use app\models\User;

class PersonalInfo extends ActiveRecord
{

    public static function tableName(){
        return "{{%personal_info}}";
    }

    public static function findIdentity($uid){
        return static::findOne( [ 'uid' => $uid ] );
    }

    public function getUserInfoModel(){
        return $this->hasOne(User::className() , [ 'id' => 'uid' ]);
    }

}

?>
