<?php

/**
 * 将商品的库存放在redis中
 */

$pdo = new PDO('mysql:host=127.0.0.1;dbname=shop',"root","root");
$sql = "select id,stock from goods";
$rows = $pdo->query($sql,PDO::FETCH_ASSOC);//执行sql数据


$redis = new Redis();
$redis->connect('127.0.0.1');

foreach($rows as $row){
     $redis->set("goods_num_{$row['id']}",$row['stock']);
}

echo "存放完毕!";