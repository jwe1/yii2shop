<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Goods_day_count extends ActiveRecord{

    public function rules()
    {
        return [
            [['day','count'],'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'day'=>'日期',
            'count'=>'商品数量'
        ];
    }

}