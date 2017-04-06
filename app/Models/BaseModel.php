<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 21:54
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const CREATED_AT = 'iCreateTime';

    const UPDATED_AT = 'iUpdateTime';

    protected $dateFormat = 'U';

    protected $primaryKey = 'iAutoID';
}