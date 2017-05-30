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


class CommonMenu extends Model
{
    protected $fillable   = [ 'sName', 'iType', 'iBusinessType', 'iCommon', 'iParentID', 'iLevel', 'sRelation',
        'sAndroidPath', 'sIosPath', 'sH5Path', 'sWebPath', 'sParam', 'iJumpType', 'sRealUrl', 'iLeaf', 'iShow',
        'sIcon', 'iOrder', 'iHome', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = [ 'iAutoID', 'sName', 'iType', 'iBusinessType', 'iCommon', 'iParentID', 'iLevel', 'sRelation',
        'sAndroidPath', 'sIosPath', 'sH5Path', 'sWebPath', 'sParam', 'iJumpType', 'sRealUrl', 'iLeaf', 'iShow',
        'sIcon', 'iOrder', 'iHome', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'common_menu';
}