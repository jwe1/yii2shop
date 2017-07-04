<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;
header('content:text/html; charset=utf-8');

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $create_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $password;//密码明文
    public $password1;//确认密码
    public $code;//验证码
    public $rememberMe; //自动登录


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //注册验证
            [['username','password','password1','email','tel','code'],'required','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['username','email'],'unique','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['username','password'], 'string', 'max' => 20,'skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['username'], 'string', 'min' => 2,'skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['password'], 'string', 'min' => 6,'skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            ['code','captcha','on'=>self::SCENARIO_API_REGISTER,'captchaAction'=>'api/captcha'],

            ['password1','compare','compareAttribute'=>'password','message'=>'两次密码不一致','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['tel'], 'string', 'length' => 11,'message'=>'手机号格式不正确','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            ['email','email','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['last_login_time', 'last_login_ip', 'status', 'create_at', 'updated_at'], 'integer','skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],
            [['auth_key'], 'string', 'max' => 255,'skipOnEmpty'=>true,'on'=>self::SCENARIO_REG],

            //登录验证
            [['username','password'/*,'code'*/],'required'],
            //['code','captcha','captchaAction'=>'user/captcha'],
            ['rememberMe','safe'],
            ['code','safe']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名：',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码：',
            'email' => '邮箱：',
            'tel' => '手机号码：',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录Ip',
            'status' => '状态',
            'create_at' => '注册时间',
            'updated_at' => '修改时间',
            'password'=>'密码：',
            'password1'=>'确认密码：',
            'code'=>'验证码：',
            'rememberMe'=>' 自动登录：'
        ];
    }

    //验证保存用户注册信息,并保存
    public function reg(){
        if($this->password != $this->password1){
            $this->addError('password1','两次密码不一致');
        }
        //验证手机验证码
       if($this->code == Yii::$app->cache->get($this->tel)){
           $this->auth_key = Yii::$app->security->generateRandomString();//生成auth_KEY
           $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);//密码加密
           $this->create_at = time();
           $this->status = 1;
           $this->save();
           return true;
        }else{
           return $this->addError('code','验证码错误');
        }

    }

    //验证并登录用户
    public function login(){
        $user = Member::findOne(['username'=>$this->username]);//查找用户名是否存在
        if($user){
            if(Yii::$app->security->validatePassword($this->password,$user->password_hash)){//比对密码
                //判断有没有勾选自动登录
                if($this->rememberMe){
                    $user->auth_key = \Yii::$app->security->generateRandomString();//自动登录生成auth_Key
                    \Yii::$app->user->login($user,3600*7*24);//设置登录时间
                }else{
                    \Yii::$app->user->login($user);
                }
                //保存数据
                $user->last_login_time = time();//设置最后登录时间
                $user->last_login_ip = ip2long($_SERVER['REMOTE_ADDR']);//ip地址转换为整形int保存
                $user->save(false);
                //将cookie中的购物车数据保存到数据库
                $cookie =\Yii::$app->request->cookies;//获取旧的cookie数据
                $old_cookies=$cookie->get('cart');
                //var_dump($old_cookies);exit;
                if($old_cookies != null){
                    $carts = unserialize($old_cookies->value);//将数据保存到数据库
                   // var_dump($carts);exit;
                    foreach ($carts as $k=>$v){
                        //判断数据库是否已经有该商品，有就合并
                        $goods= Cart::find()->andWhere(['goods_id'=>$k])->andWhere(['user_id'=>Yii::$app->user->id])->one();
                       // var_dump($goods);exit;
                        if($goods){
                            $goods->amount += $v;
                            $goods->save();
                        }else {
                            //没有就新增
                            $cart = new Cart();
                            $cart->user_id = \Yii::$app->user->id;
                            $cart->goods_id = $k;
                            $cart->amount = $v;
                            $cart->save();
                        }
                        //操作完成，清除cookie
                        Yii::$app->response->cookies->remove('cart');
                    }
                }
                return true;
            }else{
                return $this->addError('password','用户名或密码错误');
            }
        }else{
            return $this->addError('username','用户名不存在');
        }
    }



    //验证场景
    const SCENARIO_REG = 'register';//注册
    const SCENARIO_LOGIN = 'login';//登录
    const SCENARIO_API_REGISTER = 'api_register';//api注册
    public function scenarios(){
        $scenarios = parent::scenarios(); // TODO: Change the autogenerated stub
        $scenarios[self::SCENARIO_REG] = ['username','password','password1','email','tel','code'];//注册
        $scenarios[self::SCENARIO_LOGIN] = ['username','password','code'];//登录
        return $scenarios;
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
        return $this->authKey === $authKey;
        // TODO: Implement validateAuthKey() method.
    }
}
