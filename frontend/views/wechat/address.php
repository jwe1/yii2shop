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

<div class="weui-cells__title">收货地址</div>
<div class="weui-cells">
    <?php foreach ($address as $ad): ?>
    <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__bd">
            <p><?=$ad['name'].' '.$ad['tel']?>张三 18912345678</p>
        </div>
        <div class="weui-cell__ft"><?=$ad['province'].$ad['city'].$ad['area'].$ad['detail']?>四川省成都市锦江区...</div>
    </a>
    <?php endforeach; ?>
</div>

</body>
</html>
