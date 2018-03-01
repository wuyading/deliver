<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-6-26
 * Time: 上午9:31
 */

namespace App\Models;

use Carbon\Carbon;

class Order extends BaseModel
{
    function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'order';
    }

    public function getOrderInfo()
    {
        return $this->hasMany(OrderInfo::className(), ['order_no' => 'order_no']);
    }

    public function getUserInfo()
    {
        return $this->hasOne(Sysadmin::className(), ['id' => 'created_user_id']);
    }

    public function getAccountInfo()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }
}