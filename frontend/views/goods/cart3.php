<?php
/**
 *@var $this \yii\web\View
 */
$this->registerCssFile('@web/style/success.css');

?>


<!-- 主体部分 start -->
<div class="success w990 bc mt15">
    <div class="success_hd">
        <h2>订单提交成功</h2>
    </div>
    <div class="success_bd">
        <p><span></span>订单提交成功，我们将及时为您处理</p>

        <p class="message">完成支付后，你可以 <a href="order.html">查看订单状态</a>  <a href="index.html">继续购物</a> <a href="">问题反馈</a></p>
    </div>
</div>
<!-- 主体部分 end -->


<script type="text/javascript">
    //头部导航栏JS
    $(function() {
        $('.flow ul').find('li:eq(0)').attr('class', '');
        $('.flow ul').find('li:eq(2)').attr('class', 'cur');
        $('.cur').closest('div').addClass('flow3');
    });
</script>