<div style="clear:both;"></div>

<!-- 列表主体 start -->
<div class="list w1210 bc mt10">
    <!-- 面包屑导航 start -->
    <div class="breadcrumb">
        <h2>当前位置：<a href="index.html">搜索</a>  <a href="">
                <?php
                    echo  !empty($keywords)? ' > '.$keywords : '';
                ?>
            </a>

        </h2>
    </div>
    <!-- 面包屑导航 end -->

    <!-- 左侧内容 start -->
    <div class="list_left fl mt10">
        <!-- 分类列表 start -->
        <div class="catlist">
            <h2><?=1?></h2>
            <div class="catlist_wrap">
                <div class="child">
                    <h3 class="on"><b></b>电脑整机</h3>
                    <ul>
                        <li><a href="">笔记本</a></li>
                        <li><a href="">超极本</a></li>
                        <li><a href="">平板电脑</a></li>
                    </ul>
                </div>

                <div class="child">
                    <h3><b></b>电脑配件</h3>
                    <ul class="none">
                        <li><a href="">CPU</a></li>
                        <li><a href="">主板</a></li>
                        <li><a href="">显卡</a></li>
                    </ul>
                </div>

                <div class="child">
                    <h3><b></b>办公打印</h3>
                    <h3><b></b>办公打印</h3>
                    <ul class="none">
                        <li><a href="">打印机</a></li>
                        <li><a href="">一体机</a></li>
                        <li><a href="">投影机</a></li>

                    </ul>
                </div>

                <div class="child">
                    <h3><b></b>网络产品</h3>
                    <ul class="none">
                        <li><a href="">路由器</a></li>
                        <li><a href="">网卡</a></li>
                        <li><a href="">交换机</a></li>

                    </ul>
                </div>

                <div class="child">
                    <h3><b></b>外设产品</h3>
                    <ul class="none">
                        <li><a href="">鼠标</a></li>
                        <li><a href="">键盘</a></li>
                        <li><a href="">U盘</a></li>
                    </ul>
                </div>
            </div>

            <div style="clear:both; height:1px;"></div>
        </div>
        <!-- 分类列表 end -->

        <div style="clear:both;"></div>

        <!-- 新品推荐 start -->
        <div class="newgoods leftbar mt10">
            <h2><strong>新品推荐</strong></h2>
            <div class="leftbar_wrap">
                <ul>
                    <li>
                        <dl>
                            <dt><a href=""><?=\yii\helpers\Html::img(Yii::getAlias('@web/images/list_hot1.jpg'))?></a></dt>
                            <dd><a href="">美即流金丝语悦白美颜新年装4送3</a></dd>
                            <dd><strong>￥777.50</strong></dd>
                        </dl>
                    </li>

                    <li>
                        <dl>
                            <dt><a href=""><?=\yii\helpers\Html::img(Yii::getAlias('@web/images/list_hot2.jpg'))?></a></dt>
                            <dd><a href="">领券满399减50 金斯利安多维片</a></dd>
                            <dd><strong>￥239.00</strong></dd>
                        </dl>
                    </li>

                    <li class="last">
                        <dl>
                            <dt><a href=""><?=\yii\helpers\Html::img(Yii::getAlias('@web/images/list_hot3.jpg'))?></a></dt>
                            <dd><a href="">皮尔卡丹pierrecardin 男士长...</a></dd>
                            <dd><strong>￥1240.50</strong></dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 新品推荐 end -->

        <!--热销排行 start -->
        <div class="hotgoods leftbar mt10">
            <h2><strong>热销排行榜</strong></h2>
            <div class="leftbar_wrap">
                <ul>
                    <li></li>
                </ul>
            </div>
        </div>
        <!--热销排行 end -->

        <!-- 最近浏览 start -->
        <div class="viewd leftbar mt10">
            <h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
            <div class="leftbar_wrap">
                <dl>
                    <dt><a href=""><?=\yii\helpers\Html::img(Yii::getAlias('@web/images/hpG4.jpg'))?></a></dt>
                    <dd><a href="">惠普G4-1332TX 14英寸笔记...</a></dd>
                </dl>

                <dl class="last">
                    <dt><a href=""><?=\yii\helpers\Html::img(Yii::getAlias('@web/images/crazy4.jpg'))?></a></dt>
                    <dd><a href="">直降200元！TCL正1.5匹空调</a></dd>
                </dl>
            </div>
        </div>
        <!-- 最近浏览 end -->
    </div>
    <!-- 左侧内容 end -->

    <!-- 列表内容 start -->
    <div class="list_bd fl ml10 mt10">
        <!-- 热卖、促销 start -->
        <div class="list_top">
            <!-- 热卖推荐 start -->
            <div class="hotsale fl">
                <h2><strong><span class="none">热卖推荐</span></strong></h2>
                <ul>
                    <li>
                        <dl>
                            <dt><a href=""><?=\yii\helpers\Html::img(Yii::getAlias('@web/images/hpG4.jpg'))?></a></dt>
                            <dd class="name"><a href="">惠普G4-1332TX 14英寸笔记本电脑 （i5-2450M 2G 5</a></dd>
                            <dd class="price">特价：<strong>￥2999.00</strong></dd>
                            <dd class="buy"><span>立即抢购</span></dd>
                        </dl>
                    </li>

                    <li>
                        <dl>
                            <dt><a href=""><?=\yii\helpers\Html::img(Yii::getAlias('@web/images/list_hot3.jpg'))?></a></dt>
                            <dd class="name"><a href="">ThinkPad E42014英寸笔记本电脑</a></dd>
                            <dd class="price">特价：<strong>￥4199.00</strong></dd>
                            <dd class="buy"><span>立即抢购</span></dd>
                        </dl>
                    </li>

                    <li>
                        <dl>
                            <dt><a href=""><?=\yii\helpers\Html::img(Yii::getAlias('@web/images/acer4739.jpg'))?></a></dt>
                            <dd class="name"><a href="">宏碁AS4739-382G32Mnkk 14英寸笔记本电脑</a></dd>
                            <dd class="price">特价：<strong>￥2799.00</strong></dd>
                            <dd class="buy"><span>立即抢购</span></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <!-- 热卖推荐 end -->

            <!-- 促销活动 start -->
            <div class="promote fl">
                <h2><strong><span class="none">促销活动</span></strong></h2>
                <ul>
                    <li><b>.</b><a href="">DIY装机之向雷锋同志学习！</a></li>
                    <li><b>.</b><a href="">京东宏碁联合促销送好礼！</a></li>
                    <li><b>.</b><a href="">台式机笔记本三月巨惠！</a></li>
                    <li><b>.</b><a href="">富勒A53g智能人手识别鼠标</a></li>
                    <li><b>.</b><a href="">希捷硬盘白色情人节专场</a></li>
                </ul>

            </div>
            <!-- 促销活动 end -->
        </div>
        <!-- 热卖、促销 end -->

        <div style="clear:both;"></div>

        <!-- 商品筛选 start -->
        <div class="filter mt10">
            <h2><a href="">重置筛选条件</a> <strong>商品筛选</strong></h2>
            <div class="filter_wrap">
                <dl>
                    <dt>品牌：</dt>
                    <dd class="cur"><a href="">不限</a></dd>
                    <dd><a href="">联想（ThinkPad）</a></dd>
                    <dd><a href="">联想（Lenovo）</a></dd>
                    <dd><a href="">宏碁（acer）</a></dd>
                    <dd><a href="">华硕（ASUS）</a></dd>
                    <dd><a href="">戴尔（DELL）</a></dd>
                    <dd><a href="">索尼（SONY）</a></dd>
                    <dd><a href="">惠普（HP）</a></dd>
                    <dd><a href="">三星（SAMSUNG）</a></dd>
                    <dd><a href="">优派（ViewSonic）</a></dd>
                    <dd><a href="">苹果（Apple）</a></dd>
                    <dd><a href="">富士通（Fujitsu）</a></dd>
                </dl>

                <dl>
                    <dt>价格：</dt>
                    <dd class="cur"><a href="">不限</a></dd>
                    <dd><a href="">1000-1999</a></dd>
                    <dd><a href="">2000-2999</a></dd>
                    <dd><a href="">3000-3499</a></dd>
                    <dd><a href="">3500-3999</a></dd>
                    <dd><a href="">4000-4499</a></dd>
                    <dd><a href="">4500-4999</a></dd>
                    <dd><a href="">5000-5999</a></dd>
                    <dd><a href="">6000-6999</a></dd>
                    <dd><a href="">7000-7999</a></dd>
                </dl>

                <dl>
                    <dt>尺寸：</dt>
                    <dd class="cur"><a href="">不限</a></dd>
                    <dd><a href="">10.1英寸及以下</a></dd>
                    <dd><a href="">11英寸</a></dd>
                    <dd><a href="">12英寸</a></dd>
                    <dd><a href="">13英寸</a></dd>
                    <dd><a href="">14英寸</a></dd>
                    <dd><a href="">15英寸</a></dd>
                </dl>

                <dl class="last">
                    <dt>处理器：</dt>
                    <dd class="cur"><a href="">不限</a></dd>
                    <dd><a href="">intel i3</a></dd>
                    <dd><a href="">intel i5</a></dd>
                    <dd><a href="">intel i7</a></dd>
                    <dd><a href="">AMD A6</a></dd>
                    <dd><a href="">AMD A8</a></dd>
                    <dd><a href="">AMD A10</a></dd>
                    <dd><a href="">其它intel平台</a></dd>
                </dl>
            </div>
        </div>
        <!-- 商品筛选 end -->

        <div style="clear:both;"></div>

        <!-- 排序 start -->
        <div class="sort mt10">
            <dl>
                <dt>排序：</dt>
                <dd class="cur"><a href="">销量</a></dd>
                <dd><a href="">价格</a></dd>
                <dd><a href="">评论数</a></dd>
                <dd><a href="">上架时间</a></dd>
            </dl>
        </div>
        <!-- 排序 end -->

        <div style="clear:both;"></div>

        <!-- 商品列表 start-->





        <div class="goodslist mt10">
            <ul>

          <!--      一个商品一个li-->
                <?php
                    foreach ($goods as $good){
                        echo '<li>';
                        echo     '<dl>';
                        echo           '<dt><a href="goods.html?id='.$good['id'].'">';
                                        /*输出商品图片*/
                        echo                \yii\helpers\Html::img('http://admin.shop.com/'.$good['logo']);
                        echo                '</a></dt>';
                        echo           '<dd><a href="">'.$good["name"].'</a></dt>';
                        echo           '<dd><strong>￥'.$good["shop_price"].'</strong></dt>';
                        echo           '<dd><a href=""><em>已有10人评价</em></a></dt>';
                        echo    '</dl>';
                        echo '</li>';
                    }

                ?>

           <!--     <li>
                    <dl>
                        <dt><a href=""><?/*=\yii\helpers\Html::img(Yii::getAlias('@web/images/goods1.jpg'))*/?></a></dt>
                        <dd><a href="">清华同方精锐X2 台式电脑（双核E3500 2G 500G DVD 键鼠）带20英寸显示器</a></dt>
                        <dd><strong>￥2399.00</strong></dt>
                        <dd><a href=""><em>已有10人评价</em></a></dt>
                    </dl>
                </li>

                <li>
                    <dl>
                        <dt><a href=""><?/*=\yii\helpers\Html::img(Yii::getAlias('@web/images/goods2.jpg'))*/?></a></dt>
                        <dd><a href="">富士通LH531 14.1英寸笔记本电脑（i3-2350M 2G 320G 第二代核芯显卡 D刻</a></dd>
                        <dd><strong>￥2999.00</strong></dd>
                        <dd><a href=""><em>已有5人评价</em></a></dd>
                    </dl>
                </li>

                <li>
                    <dl>
                        <dt><a href=""><?/*=\yii\helpers\Html::img(Yii::getAlias('@web/images/goods3.jpg'))*/?></a></dt>
                        <dd><a href="">三星Galaxy Tab P6800 7.7英寸 3G手机版 蓝牙3.0 魔丽屏 金属银</a></dd>
                        <dd><strong>￥4699.00</strong></dd>
                        <dd><a href=""><em>已有34人评价</em></a></dd>
                    </dl>
                </li>

                <li>
                    <dl>
                        <dt><a href=""><?/*=\yii\helpers\Html::img(Yii::getAlias('@web/images/goods4.jpg'))*/?></a></dt>
                        <dd><a href="">宏碁AS4739-382G32Mnkk 14英寸笔记本电脑（i3-380M 2G 320G D刻 LED背</a></dd>
                        <dd><strong>￥2799.00</strong></dd>
                        <dd><a href=""><em>已有17人评价</em></a></dd>
                    </dl>
                </li>

                <li>
                    <dl>
                        <dt><a href=""><?/*=\yii\helpers\Html::img(Yii::getAlias('@web/images/goods5.jpg'))*/?></a></dt>
                        <dd><a href="">ThinkPad E42014英寸笔记本电脑（i5-2450M 2G 320G 蓝牙 摄像头）</a></dd>
                        <dd><strong>￥4199.00</strong></dd>
                        <dd><a href=""><em>已有8人评价</em></a></dd>
                    </dl>
                </li>

                <li>
                    <dl>
                        <dt><a href=""><?/*=\yii\helpers\Html::img(Yii::getAlias('@web/images/goods6.jpg'))*/?></a></dt>
                        <dd><a href="">惠普G4-1332TX 14英寸笔记本电脑 （i5-2450M 2G 500G 7450M 1G独显 D刻</a></dd>
                        <dd><strong>￥2999.00</strong></dd>
                        <dd><a href=""><em>已有22人评价</em></a></dd>
                    </dl>
                </li>-->
            </ul>
        </div>
        <!-- 商品列表 end-->


        <!-- 分页信息 start -->
        <div class="page mt20">
            <?php
            use yii\widgets\LinkPager;
            echo \yii\widgets\LinkPager::widget([
                'pagination'=>$page,
                'nextPageLabel'=>'下一页',
                'prevPageLabel'=>'上一页',
              /*  'firstPageLabel' => '首页',
                'lastPageLabel' => '尾页',*/
                'options' => ['style' => 'background:red;','class'=>'wo_page'],
            ]);
            ?>
            <!--
               <a href="">尾页</a>&nbsp;&nbsp;
                   <span>
                       <em>共8页&nbsp;&nbsp;到第 <input type="text" class="page_num" value="3"/> 页</em>
                       <a href="" class="skipsearch" href="javascript:;">确定</a>
                   </span>-->
        </div>
        <!-- 分页信息 end -->

    </div>
    <!-- 列表内容 end -->
</div>
<!-- 列表主体 end-->

<div style="clear:both;"></div>

