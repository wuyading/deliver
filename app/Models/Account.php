<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-6-26
 * Time: 上午9:31
 */

namespace App\Models;

class Account extends BaseModel
{
    function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'account';
    }
}