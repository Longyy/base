<?php
namespace App\Http\Helpers;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 23:39
 */
class Tools
{
    /**
     * 取二维数组的子数组的一个元素作为键名。
     *
     * @param array $aArray 传入的二维数组
     * @param string $sFiled 需要作为key的字段
     * @return array
     */
    public static function useFieldAsKey($aArray, $sFiled) {
        if(!is_array($aArray) || !count($aArray) || !is_array(current($aArray))) {
            return $aArray;
        }
        $aResult = array();
        foreach($aArray as $v) {
            $aResult[$v[$sFiled]] = $v;
        }
        return $aResult;
    }

    /**
     * 取二维数组（或一维对象）的指定字段集合
     *
     * @param array $aArray 传入的二维数组
     * @param string $sFiled 要取的字段
     * @return array
     */
    static public function getFieldValues($aArray, $sFiled) {
        if(!is_array($aArray) || !count($aArray)) {
            return [];
        }
        $aResult = [];
        foreach($aArray as $v) {
            if(is_array($v) && isset($v[$sFiled])) {
                $aResult[] = $v[$sFiled];
            } else if(is_object($v) && isset($v->$sFiled)) {
                $aResult[] = $v->$sFiled;
            }
        }
        return is_array(array_get($aResult, 0, null)) ? $aResult : array_unique($aResult);
    }
}