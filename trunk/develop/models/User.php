<?php
namespace app\models;

use Yii;
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
// class Users extends \yii\db\ActiveRecord
{

    //暂未启用的属性，为防止代码出错临时写在这儿。
    public $authKey = null;
    public $roles = null;//RBAC 角色 yii\rbac\Role[]
    public $permissions = null;//RBAC 许可 yii\rbac\Permission[]
    // public $sessionid = null;//设备识别符


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
            [['user_login','user_pass'], 'safe'],

            //管理-创建
            // [['username'], 'required','on'=>'admin-create'],
        ];
    }

    /**
     * 场景
     * @return [type] [description]
     */
    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['admin-create'] = $scenarios['default'];
        //管理员更新
        $scenarios['admin-update'] = $scenarios['default'];
        foreach ($scenarios['admin-update'] as $key => $value) {
           if(  $value == 'username'  )
                $scenarios['admin-update'][$key] = '!username';
        }
        // unset($scenarios['adminupdate']['username']);
        // $scenarios['adminupdate'][] = '!username';//用户名不能以块赋值的方式修改
        return $scenarios;
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID'          => 'UID',
            'user_login'     => '用户名',
            'user_pass'      => '密码',
        ];
    }

    public function relations()
    {
        return array(
            'info'=>array(self::HAS_ONE,'Userinfo','','on'=>'ui.userid=t.id','alias'=>'ui'),
        );
    }

    //删除前        beforeDelete
    public function beforeDelete(){
            $this->addError( 'username', $error = 'sys[model]:Forbid delete user.' );
            return fasle;
    }

    //更新后
    public function afterSave($insert, $changedAttributes){
        //如果更新了用户组，则设置其权限;
        if(  isset($changedAttributes['groupid']) || $insert  )            
            $this->setRole($this->group->defaultrole);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
          $user = User::find()
            ->where(['user_login' => $username])
            ->asArray()
            ->one();
            if($user){
                return new static($user);
        }
        return null;
    }

    public function getGroupid(){
        return $this->hasOne(UserGroup::className(), ['groupid' => 'groupid']);
    }


     /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->ID;
    }

    public function getUid(){
        return $this->ID;
    }

    public function getUsername(){
        return $this->user_login;
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
     * 认证密码
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->user_pass === $this->encryptPassword($password);
    }


    /**
     * 检查权限
     * @param  string/array $permissions 许可名称或名称组     
     */
    public function check($permissions){
        if(   Yii::$app->user->isGuest  )
            return false;
        $_permissions = $this->getPermissions();
        //如果许可代码为字符串
        if(  is_string($permissions)  )
            return isset($_permissions[$permissions]);
        //如果许可代码为数组
        if(  is_array($permissions)  )
            foreach ($permissions as $kp => $permission)
                if(  !isset($_permissions[$permission])  )return false;
        return true;
    }


    /**
     * 密码加密方式
     * @param  string $password 密码明文
     * @return string           密文
     */
    public function  encryptPassword($password){
        return md5(md5($password));
    }

    /**
     * 关联用户组
     * @return [type] [description]
     */
    public function getGroup(){
        return UserGroup::findOne($this->groupid);
    }

    /**
     * 关联银行
     * @return [type] [description]
     */
    // public function getBank(){
    //     return Bank::findOne($this->bankid);
    // }

    /**
     * 获取授权代码
     * @return [type] [description]
     */
    public function getRoles(){
        if(  is_null($this->roles)  ){
                $manager = Yii::$app->authManager;
                $this->roles = $manager->getRolesByUser($this->uid);    
        }
        return $this->roles;
    }

    /**
     * 获取授权代码
     * @return [type] [description]
     */
    public function getPermissions(){
        if(  is_null($this->permissions)  ){
                $manager = Yii::$app->authManager;
                $this->permissions = $manager->getPermissionsByUser($this->uid);    
        }
        return $this->permissions;
    }


    /**
     * 设置角色
     * @param string/array $roles 角色、角色列表
     */
    public function setRole($roles){
        /**
         * 移除现有角色
         */
        $manager = Yii::$app->authManager;
        $myRoles = $manager->getRolesByUser($this->uid);
        if(  $myRoles  )
            foreach ($myRoles as $kr => $myRole)
                $manager->revoke($myRole,$this->uid); 
        
        /**
         * 设置新角色
         */
        if(  is_string($roles)  )
            return $this->addRole($roles);
        if(  is_array($roles)  )
            foreach ($roles as $kr => $role)
                $this->addRole($role);
        return true;       
    }

    /**
     * 添加角色
     * @param [type] $name [description]
     * @return  boolean
     */
    public function addRole($name){
        $manager = Yii::$app->authManager;
        $item = $manager->getRole($name);
        return $manager->assign($item, $this->uid);
    }

    /**
     * 移除角色
     * @param  string $name 角色名称
     * @return boolean 成功
     */
    public function removeRole($name){
        $manager = Yii::$app->authManager;
        $item = $manager->getRole($name);            
        return $manager->revoke($item, $this->uid);
    }


}


   