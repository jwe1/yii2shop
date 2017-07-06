<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>WeUI</title>
    <!-- 引入 WeUI -->
    <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
    <link rel="stylesheet" href="//weui.io/example.css"/>
</head>
<body>
<div class="weui-cells__title">订单列表</div>
<div class="weui-cells">
    <?php foreach ($all_goods as $good):?>
    <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__hd"><img src="https://img10.360buyimg.com/n5/s54x54_jfs/t6025/5/296812741/230628/26c725b1/5927a1a0N82f6fbcc.jpg" alt="" style="width:20px;margin-right:5px;display:block"></div>
        <div class="weui-cell__bd">
            <p><?=$good['goods_name']?></p>
        </div>
        <div class="weui-cell__ft"><?=date('Y-m-d',$good['create_time'])?></div>
    </a>
    <?php endforeach; ?>
   <!-- <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__hd"><img src="https://img13.360buyimg.com/n5/s54x54_jfs/t4642/110/753072126/121222/5556881f/58d484a0N1d9d2ebf.jpg" alt="" style="width:20px;margin-right:5px;display:block"></div>
        <div class="weui-cell__bd">
            <p>iphone7</p>
        </div>
        <div class="weui-cell__ft">2017-07-02</div>
    </a>
    <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__hd"><img src="https://img11.360buyimg.com/n5/jfs/t5782/56/4176074588/316874/2a6fa3cf/5949deefN37d88dd7.jpg" alt="" style="width:20px;margin-right:5px;display:block"></div>
        <div class="weui-cell__bd">
            <p>杜蕾斯</p>
        </div>
        <div class="weui-cell__ft">2017-07-03</div>
    </a>
    <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__hd"><img src="https://img13.360buyimg.com/n5/jfs/t3352/22/238019396/252069/16d9bd13/580447a1N6ec660ad.jpg" alt="" style="width:20px;margin-right:5px;display:block"></div>
        <div class="weui-cell__bd">
            <p>索尼55寸液晶电视</p>
        </div>
        <div class="weui-cell__ft">2017-07-04</div>
    </a>-->
</div>



</body>
</html>
