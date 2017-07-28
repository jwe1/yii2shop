<?php

/**
 *  被定时任务一秒钟执行一次.，，，，，，，，，，写个计划任务bat
 *    1. 库存需要减少
 *    2. redis中的数据要清除
 */

//>>1. 取出redis中  goods:* 的键. 因为这些键对应的值是list,list存放每个抢购成功的用户
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=shop',"root","root");

    $redis = new Redis();
    $redis->connect('127.0.0.1');
    $keys = $redis->keys("goods:*");//所有商品list

    $pdo->beginTransaction();//通过PDO开启事务
    try{
        foreach($keys as $key){
            //>>2 分离出商品的id
            $goods_id = explode(":",$key)[1];
            //>>3 根据key找到对应的抢购成功的用户id
            $userids = $redis->lRange($key,0,-1);
            foreach($userids as $userid){

                //检查是否购买过该商品
                $sql = "select count(*) from `miaosha_order` where goods_id={$goods_id} and user_id={$userid}";
                $value = $pdo->query($sql)->fetchColumn(0);

                //>>4.将$userid和$goods_id 保存到order表中
                if($value==0){ //没有购买过
                    $sql1 = "insert into `miaosha_order` values(null,{$goods_id},{$userid},1)";//添加生成订单
                    $sql2 = "update goods set stock - 1 where id = {$goods_id}";//更新库存
                    $pdo->exec($sql1);
                    $pdo->exec($sql2);
                }
            }
        }
        $pdo->commit();//提交事务
    }catch (PDOException $e){
        $pdo->rollBack();//回滚事务
    }


