<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 21:52
 */
namespace App\Models\Perm;

use Estate\Database\Eloquent\Model;
use Estate\Exceptions\ServiceException;


class CommonResource extends Model
{
    protected $fillable   = [ 'sName', 'iType', 'iBusinessType', 'sControllerName', 'sFunctionName', 'sPath',
        'iShow', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = [ 'sName', 'iType', 'iBusinessType', 'sControllerName', 'sFunctionName', 'sPath',
        'iShow', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'common_resource';


}