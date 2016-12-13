<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

class City extends ActiveRecord
{

    public static function tableName()
    {
        //%自动匹配表前缀（app_register_user）
        return '{{%base_area}}';
    }

}
