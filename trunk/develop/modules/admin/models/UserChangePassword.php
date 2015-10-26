<?php
namespace sv\admin\models;
use app\models\User;

use Yii;

class UserChangePassword extends \yii\db\ActiveRecord
// class Users extends \yii\db\ActiveRecord
{

    public $passwordn = null;//新密码
    public $passwordr = null;//重复密码
    public $passwordo = null;//原密码

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['passwordn', 'passwordr', 'passwordo'], 'required'],
            [['passwordn', 'passwordr' ], 'string','min' => 5, 'max' => 30],
            [['passwordn', 'passwordr' ], 'passwordCheck'],
            [['ID'], 'safe'],
        ];
    }

    public function passwordCheck($attributes,$param){
        $user = User::findOne( $this->ID );
        if(  $this->passwordn == $this->passwordo  )
            $this->addError('passwordn','原密码与新密码不能一样');
        if(  $this->passwordn != $this->passwordr  )
            $this->addError('passwordr','与新密码不一致');
        if(  $user->user_pass != $user->encryptPassword($this->passwordo) )
            $this->addError('passwordo','原密码错误');
        
        $this->user_pass = $user->encryptPassword( $this->passwordn);
    }


    public function attributeLabels()
    {
        return [
            'passwordn'     => '新密码',
            'passwordr'     => '重复密码',
            'passwordo'     => '原密码',
        ];
    }




}


   