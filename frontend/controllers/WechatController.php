<?php
namespace frontend\controllers;

use EasyWeChat\Message\News;
use frontend\models\Address;
use frontend\models\Goods;
use frontend\models\Member;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\helpers\Url;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller{
    public function actionTest1(){
        var_dump(123);exit;
    }
    //微信开发依赖的插件  easyWechat
    //关闭csrf验证
    public $enableCsrfValidation = false;


    public function actionIndex()//主页
    {
        $app = new Application(\Yii::$app->params['wechat']);
        $app->server->setMessageHandler(function ($message){
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text。。。
            switch($message->MsgType){
                case 'text':
                    switch($message->Content){
                        case '帮助':
                            return '您可以发送 帮助 优惠、解除绑定 等信息';
                            break;
                        case '优惠'://返回5条图文信息
                            $goods = Goods::find()->limit(5)->all();
                            $news = [];
                            foreach ($goods as $k=>$good){
                                $new = new News([
                                    'title'       => $good['name'],
                                    'description' => $good['name'],
                                    'url'         => 'http://120.77.80.205/shop/frontend/web/goods/goods.html?cate='.$good['goods_category_id'].'&'.'id='.$good['id'].'\'',
                                    'image'       => 'http://admin.shop.com/'.$good['logo'],
                                ]);
                                $news[] =$new;
                            }
                            return $news;//返回活动
                            break;
                        case '解除绑定':
                            //找到发送方openid
                            $member = Member::findOne(['openid'=>$message->FromUserName]);
                            if($member == null){
                                return '账户未绑定，无需解绑';
                            }else{
                                $member->openid = '';
                                $member->save(false);
                                return '解绑成功';
                            }
                            break;
                    }
                    return '您可以发送 帮助 优惠、解除绑定 等信息';
                    break;

                case 'event'://点击事件
                    //事件的类型   $message->Event
                    // $message->Event;
                    //事件的key值  $message->EventKey
                    if($message->Event == 'CLICK'){//菜单点击事件，返回图文信息
                        if($message->EventKey == 'chu_xiao'){//用户输入zuixinhondong,返回活动图文信息
                            $goods = Goods::find()->limit(5)->all();//获取5条商品返回
                            $news = [];
                            foreach ($goods as $k=>$good){
                                $new = new News([
                                    'title'       => $good['name'],
                                    'description' => $good['name'],
                                    'url'         => 'http://120.77.80.205/shop/frontend/web/goods/goods.html?cate='.$good['goods_category_id'].'&'.'id='.$good['id'].'\'',
                                    'image'       => 'http://admin.shop.com/'.$good['logo'],
                                ]);
                                $news[] =$new;
                            }
                            return $news;//返回活动商品
                        }
                    }
                break;
            }
            return '收到你的信息：'.$message->Content;
        });
        $response = $app->server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }


    public function actionSetMenu()//设置菜单
    {
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        //菜单选项
        $button = [
            [
                "type" => "click",
                "name" => "促销商品",
                "key"  => "chu_xiao"
            ],
            [
                "type" => "view",
                "name" => "在线商城",
                "url"  => Url::to(['goods/index'],true)
            ],
            [
                "name" => "个人中心",
                "sub_button" => [
                    [//菜单选项
                        "type" => "view",
                        "name" => "我的订单",
                        "url"  => Url::to(['wechat/order'],true),
                    ],

                    [
                        "type" => "view",
                        "name" => "绑定账户",
                        "url"  => Url::to(['wechat/login'],true),
                    ],
                    [
                        "type" => "view",
                        "name" => "收货地址",
                        "url" => Url::to(['wechat/address'],true),
                    ],
                    [
                        "type" => "view",
                        "name" => "修改密码",
                        "url" => Url::to(['wechat/changepwd'],true),
                    ],
                    [
                        "type" => "view",
                        "name" => "安全退出",
                        "url" => Url::to(['wechat/logout'],true),
                    ]
                ]
            ]
        ];
        $menu->add($button);//添加button
        //获取已设置的菜单（查询菜单）
         $menu->all();
    }


    public function actionOrder()//订单页面
    {
        if(\Yii::$app->user->isGuest){//用户没有登录，引导用户登录
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);//设置跳回页面
            return $this->redirect(['login']);
        }
        //用户登录了，直接显示订单页面
        $openid = \Yii::$app->session->get('openid');
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            //设置session返回跳转页
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);//uniqueid获得当前方法名
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])->redirect();
            $response->send();
            //已经获得openid
        }

        //通过openid获取订单
        $member = Member::findOne(['openid'=>$openid]);
        if(!$member){
            //该openid没有绑定任何账户，引导用户登录绑定
            return $this->redirect(['login']);
        }
        //绑定了账户，获取订单
        $orders = Order::findAll(['member_id'=>$member->id]);
        //获取订单中商品
        $all_goods =[];
        foreach ($orders as $order){
            $goods = OrderGoods::find()->asArray()->where(['order_id'=>$order->id])->all();
            foreach ($goods as $good){
                $good['create_time'] = $order->create_time;
                $all_goods[] = $good;
            }
        }
        return $this->renderPartial('order',['all_goods'=>$all_goods]);
    }


  /*  public function actionUser()//个人中心,登录并授权
    {
        $openid = \Yii::$app->session->get('openid');//SESSION中的openid
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }
        var_dump($openid);
    }*/


    public function actionCallback()//授权回调页，获得授权后跳回请求页
    {
        $app = new Application(\Yii::$app->params['wechat']);
        //获取已授权用户
        $user = $app->oauth->user();
        // $user 可以用的方法:
        // $user->getId();  // 对应微信的 OPENID
        // $user->getNickname(); // 对应微信的 nickname
        // $user->getName(); // 对应微信的 nickname
        // $user->getAvatar(); // 头像网址
        // $user->getOriginal(); // 原始API返回的结果
        // $user->getToken(); // access_token， 比如用于地址共享时使用
        //将openid放入session

        \Yii::$app->session->set('openid',$user->getId());

        return $this->redirect(\Yii::$app->session->get('redirect'));//跳转回原来的页面
    }


    public function actionLogin() //绑定openid与账户,登录后绑定
    {
        //1. 得到openid
        $openid = \Yii::$app->session->get('openid');//得到openid
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }
        //2.判断openid是否已经绑定
        $user = Member::findOne(['openid'=>$openid]);
       if($user){//如果该openid已绑定账户，则取消绑定
            return $this->renderPartial('unlink');
        }
        //3.让用户登录，如果登录成功，将openid写入当前登录账户
        $request = \Yii::$app->request;
        if($request->isPost){
            //登录
            $user = Member::findOne(['username'=>$request->post('username')]);
            if($user && \Yii::$app->security->validatePassword($request->post('password'),$user->password_hash)){
                \Yii::$app->user->login($user);
                //如果登录成功，将openid写入当前登录账户
                Member::updateAll(['openid'=>$openid],'id='.$user->id);
                if(\Yii::$app->session->get('redirect')){
                    return $this->redirect([\Yii::$app->session->get('redirect')]);
                }
                return '绑定成功';
            }else{
                return '绑定失败';
            }
        }
        return $this->renderPartial('login');//显示登录页面
    }


    public function actionAddress()//地址
    {
        $openid = \Yii::$app->session->get('openid');//SESSION中的openid
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }
        //通过openid获取账号
        $member = Member::findOne(['openid'=>$openid]);
        if(!$member){
            //该openid没有绑定任何账户，引导用户登录绑定
            return $this->redirect(['login']);
        }else{
            //绑定了账户，直接获取订单
            $address = Address::find()->asArray()->where(['user_id'=>$member->id])->all();
            return $this->renderPartial('address',['address'=>$address]);
        }
    }


    public function actionChangePwd()//修改密码
    {
        if(\Yii::$app->user->isGuest){//登录
            //设置登录后的返回页面
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            return $this->redirect(['login']);
        }else{//已经登录
            if(\Yii::$app->request->isPost){
                //$Member = new Member(['scenario'=>Member::SCENARIO_CHANGE_PWD]);
                $member = Member::findOne(['id'=>\Yii::$app->user->id]);//获取当前用户
               if(!\Yii::$app->security->validatePassword($_POST['old_password'],$member->password_hash)){
                    return '旧密码错误';
               }
                if($_POST['password'] != $_POST['password1']){
                    return '两次密码不一致';
                }
                $member->password_hash = \Yii::$app->security->generatePasswordHash($member->password1);
                $member->save();
                return '修改成功';
                //return $this->redirect(['index']);
            }
        return $this->renderPartial('changepwd');
        }
    }



    public function actionLogout()//注销
    {
        //清除session,openid
       $member =  Member::findOne(['openid'=>\Yii::$app->session->get('openid')]);
       if($member){
           unset($member->openid);
           $member->save();
       }
        \Yii::$app->session->removeAll();
        \Yii::$app->user->logout();
      //  return $this->redirect(['login']);
    }


    public function actionTest()//测试
    {
        \Yii::$app->session->removeAll();
    }


}


