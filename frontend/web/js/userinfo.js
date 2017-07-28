
$.getJSON('/goods/user-info.html',function (data) {
    if(data.status ==1 ){
        html = '您好，欢迎来到京西！'+data.name+'|| [<a href="http://www.shop.com/user/logout.html"> 注销 </a> ] '
        $('.user-info').html(html);

        html1 = '您好: '+data.name+'!';
        $('.prompt').html(html1);
    }
});