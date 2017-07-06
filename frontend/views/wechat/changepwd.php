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
<!-- 使用 -->
<div class="weui-cells__title">修改密码</div>
<form method="post" action="http://120.77.80.205/shop/frontend/web/wechat/change-pwd.html">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">旧密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="old_password" type="password" placeholder="请输入旧密码">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">新密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="password" type="password" placeholder="请输入新密码">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">确认新密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="password1" type="password" placeholder="请再次输入新密码">
            </div>
        </div>
        <div class="weui-btn-area">
            <button  class="weui-btn weui-btn_primary">提交</button>
        </div>

    </div>

</form>


</body>
</html>
