<?php
namespace frontend\console;

use frontend\models\Goods;
use yii\db\Query;
use yii\web\Controller;
//任务
class TaskController extends Controller{
    //生成首页静态文件
    public function actionIndex(){
        $this->layout = 'goodsindex';
        $content = $this->render('@frontend/views/goods/index');
        //内容放到web下的index.html
        file_put_contents(\Yii::getAlias('@webroot').'/index.html',$content);
    }


    //将商品浏览数写入到数据库,每次跟新1000条
    public function actionGoodsView(){
        //链接redis
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        //判断当前跟新了多少次
        $goods_view_times = $redis->get('goods_view_times');
        if($goods_view_times ==null ){
            $goods_view_times = 0;
        }
        //查出1000条商品id
        $query = new Query();
        $ids = $query->select('id')->from('goods')->limit(1000)->offset($goods_view_times*1000)->column();
        if(empty($ids)){//更新完成
            $redis->del('goods_view_times');
            echo 'over';exit;
        }

        foreach ($ids as $id){
            $times = $redis->get('views_'.$id);
            if($times){
                Goods::updateAll(['views'=>$times],['id'=>$id]);
            }
        }
        //记录当前更新了多少个1000
        $redis->incr('goods_view_times');
    }


}