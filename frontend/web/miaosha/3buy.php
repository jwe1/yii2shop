<?php
header("Content-Type: text/html;charset=utf-8");
//>>1. 得到当前登录用户的id
session_start();
for($i=2;$i<100;++$i){
    $userid =$i;

//   $userid = $_SESSION['userid'];

//>>2. 将用户id放在redis的集合list中(从左放入)
    //>>2.1 连接上redis
    $redis = new Redis();
    $redis->connect('127.0.0.1');

    $goods_id = $_GET['id'];//得到要抢购的商品id
    //>>2.2 判断商品是否被抢完了(list中的长度和库存的数量(提前放在redis中)进行对比)
    if($redis->lLen("goods:{$goods_id}")<$redis->get("goods_num_{$goods_id}") ){
        //>>2. 向redis的  goods:$id键对应的list中放用户的id
        $userids = $redis->lRange("goods:{$goods_id}",0,-1);//查询出所有userids
        if(!in_array($userid,$userids)){  //判断用户是否重复抢购
            $redis->lPush("goods:{$goods_id}",$userid);
        }else{
            exit("已经抢过了!");
        }
    }else{
        exit("商品已经被抢光了!");

    }
}
