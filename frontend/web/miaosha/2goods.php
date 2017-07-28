<?php
header("Content-Type: text/html;charset=utf-8");
/**
 * 罗列出抢购页面
 */


//>>1.查询goods表中的商品数据

$pdo = new PDO('mysql:host=127.0.0.1;dbname=shop',"root","root");
$sql = "select id,name from goods";
$rows = $pdo->query($sql,PDO::FETCH_ASSOC);//执行sql数据
//>>2. 商品数据在页面上显示
?>

<table border="1px" width="30%">
    <tr>
        <td>ID</td>
        <td>商品名称</td>
        <td>抢购</td>
    </tr>
    <?php foreach($rows as $row): ?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['name']?></td>
            <td><a href="buy.php?id=<?=$row['id']?>">抢购</a></td>
        </tr>
    <?php endForeach;?>
</table>


