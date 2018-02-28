<?php

namespace App\Models;


class Product extends BaseModel
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'product';
    }

    public function getCategorys()
    {
        return $this->hasOne(Category::className(),['id'=>'brand_id']);
    }

}