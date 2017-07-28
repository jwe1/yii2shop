<?php
namespace  frontend\controllers;

use yii\web\Controller;

class StaticController extends Controller{
    //生成首页静态文件
    public function actionIndex(){
        $this->layout = 'goodsindex';
        $content = $this->render('@frontend/views/goods/index');
        //内容放到web下的index.html
        file_put_contents(\Yii::getAlias('@webroot').'/index.html',$content);
    }

}