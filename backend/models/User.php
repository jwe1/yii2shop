<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
header('Content-type:text/html;charset=utf-8');
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_time
 * @property string $last_login_ip
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */

    public $password2;//确认密码
    public $code;//验证码
    public $password1;//新密码
    public $password;//密码
    public $password_m;//旧密码
    public $rememberme;
    public $login_user;

    public $roles;//用户角色

    public static $status = ['1'=>'正常','0'=>'禁用'];

    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //登录验证
            [['username','code'],'required','skipOnEmpty'=>true,'on'=>self::SCENARIO_LOGIN],
            ['last_login_time','integer','skipOnEmpty'=>true,'on'=>self::SCENARIO_LOGIN],
            ['last_login_ip','string','skipOnEmpty'=>true,'on'=>self::SCENARIO_LOGIN],
            ['rememberme','boolean'],
            ['code','captcha','captchaAction'=>'user/captcha'],
           //注册验证
            [['username', 'password1', 'password_hash', 'email','status' ], 'required','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['status', 'created_at', 'updated_at', 'last_login_time'], 'integer','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['username', 'password_hash', 'password_reset_token', 'email', 'last_login_ip'], 'string', 'max' => 255,'skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            //[['auth_key'], 'string', 'max' => 32,'skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['username'], 'unique','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['email'], 'unique','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['email'], 'email','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
           // [['password_reset_token'], 'unique','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            ['password1','compare','compareAttribute'=>'password_hash','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            ['roles','safe'],//表示该字段不需要验证

            //修改验证
            [['username','password','password1','password2','email','status'],'required','skipOnEmpty'=>true,'on'=>self::SCENARIO_EDIT],
            ['password2','validateedit','skipOnEmpty'=>true,'on'=>self::SCENARIO_EDIT],
        ];
    }

    //修改密码验证
    public function validateedit(){
        $user = self::findOne(['username'=>$this->username]);//鎵惧埌璇ョ敤鎴峰璞�
        $compare = \Yii::$app->security->validatePassword($this->password,$user->password_hash);//楠岃瘉鏃у瘑鐮�
        if($compare){
            if($this->password1 != $this->password2){
                $this->addError('password2','两次密码不一致');
            }else{
                //验证成功保存
                $user->password_hash  = \Yii::$app->security->generatePasswordHash($this->password1);//瀵嗙爜璧嬪€�
                $user->updated_at = time();
                $user->email = $this->email;
                $user->status = $this->status;
                 $user->save(false);//保存

                //修改权限
                $id = $user->id;//获得ID
                $authmanage = \Yii::$app->authManager;
                //先清除原来的角色
                $authmanage->revokeAll($id);
                //添加新角色
                foreach ($this->roles as $role){//循环分配多个角色
                    $ro = $authmanage->getRole($role);//找到角色
                    $authmanage->assign($ro,$id);//将角色分配到当前ID
                }
                return true;
            }
        }else{
            $this->addError('password','旧密码错误');
        }
    }


    //1.获取所有的角色
    static public function getRolelist(){
        //获取到所有角色
        $roles = \Yii::$app->authManager->getRoles();
        return ArrayHelper::map($roles,'name','name');//key=>value形式
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱地址',
            'status' => '状态',
            'created_at' => '注册时间',
            'updated_at' => '最后修改时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'code'=>'验证码',
            'rememberme'=>'自动登录',
            'password'=>'旧密码',
            'password1'=>'确认密码',
            'password2'=>'确认密码',
            'password_m'=>'密码',
            'roles'=>'用户角色'
        ];
    }

    //设置验证场景
    const SCENARIO_REG = 'register';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_EDIT = 'edit';
    public function scenarios(){
        $scenarios = parent::scenarios(); // TODO: Change the autogenerated stub
        $scenarios[self::SCENARIO_REG] = ['username','password1','password_hash','email','status','roles'];//注册
        $scenarios[self::SCENARIO_LOGIN] = ['username','password_m','code','rememberme'];//登录
        $scenarios[self::SCENARIO_EDIT] = ['roles','password','password1','password2','email','username','status'];//修改
        return $scenarios;
    }

        //保存之前执行得内容
        public function beforeSave($insert)
        {
            if($insert){
                $this->created_at = time();//保存注册时间
               // $this->status = 1;
                //生成随机字符串auth_key
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            //判断修改密码
            if($this->password){
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            }
            return parent::beforeSave($insert); // TODO: Change the autogenerated stub
        }


    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->authKey === $authKey;
    }



}
