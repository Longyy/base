<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 21:52
 */
namespace App\Models\Perm;

use App\Models\BaseModel;

class CommonUserGroup extends BaseModel
{
//    protected $connection = 'zt_db';
    protected $fillable   = ['sName', 'iType', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = ['iAutoID', 'sName', 'iType', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'common_usergroup';


}