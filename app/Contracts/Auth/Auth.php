<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/26
 * Time: 20:54
 */

namespace App\Contracts\Auth;


interface Auth
{
    public function guest();

    public function check();

    public function user();



}