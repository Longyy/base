<?php
/**
 * Created by PhpStorm.
 * UserModules: Administrator
 * Date: 2017/3/30
 * Time: 21:09
 */

namespace App\Modules\Perm;

use App\Http\Helpers\Tools;
use App\Models\Perm\CommonUserGroup;
use App\Models\Perm\UserGroup;
use App\Models\User;
use Response;
use Estate\Exceptions\MobiException;

class UserGroupModules
{
    const USER_GROUP_MAIN = 1; // 主用户组
    const USER_GROUP_TEMP = 2; // 临时用户组
    const USER_GROUP_EXT = 3; // 扩展用户组

    private static $aGroupType = [
        1 => '系统用户组',
        2 => '普通用户组',
        3 => '特殊用户组',
        4 => '扩展用户组',
    ];

    public static function getGroupType()
    {
        return self::$aGroupType;
    }

    public static function getUserList($aParam)
    {

        if(empty($aParam['iUserGroupType'])) {
            return Response::exceptionMobi(new MobiException('PARAMETER_ERROR'));
        }
        if($aParam['iUserGroupType'] == self::USER_GROUP_MAIN) {
            $aResult = User::findAll(
                array_except($aParam, ['page_size', 'iUserGroupType']),
                array_get($aParam, 'page_size', 10),
                User::columns(),
                User::orders(),
                User::ranges()
            )->toArray();
            $aGroupID = array_unique(array_filter(array_column($aResult['data'], 'iGroupID')));
            $aGroupInfo = [];
            if($aGroupID) {
                $aGroupInfo = CommonUserGroup::whereIn('iAutoID', $aGroupID)->get()->toArray();
                $aGroupInfo = Tools::useFieldAsKey($aGroupInfo, 'iAutoID');
            }
            $aResult['data'] = array_map(function($aItem) use ($aGroupInfo){
                $aData = array_only($aItem, ['iAutoID', 'sName', 'sGroupName']);
                $aData['iUserID'] = $aData['iAutoID'];
                if(isset($aGroupInfo[$aItem['iGroupID']])) {
                    $aData['sGroupType'] = self::$aGroupType[$aGroupInfo[$aItem['iGroupID']]['iType']];
                }
                $aData['sExpireTime'] = '-';
                $aData['iPrepend'] = 1;
                $aData['sCreateTime'] = date('Y-m-d H:i:s', $aItem['iCreateTime']);
                $aData['sUpdateTime'] = date('Y-m-d H:i:s', $aItem['iUpdateTime']);
                return $aData;
            }, $aResult['data']);
        } else {
            $aParam['iGroupType'] = $aParam['iUserGroupType'];
            $aResult = UserGroup::findAll(
                array_except($aParam, ['page_size', 'iUserGroupType']),
                array_get($aParam, 'page_size', 10),
                UserGroup::columns(),
                UserGroup::orders(),
                UserGroup::ranges()
            )->toArray();
            $aUserID = array_unique(array_filter(array_column($aResult['data'], 'iUserID')));
            $aUserInfo = [];
            if($aUserID) {
                $aUserInfo = User::whereIn('iAutoID', $aUserID)->get()->toArray();
                $aUserInfo = Tools::useFieldAsKey($aUserInfo, 'iAutoID');
            }

            $aGroupID = array_unique(array_filter(array_column($aResult['data'], 'iGroupID')));
            $aGroupInfo = [];
            if($aGroupID) {
                $aGroupInfo = CommonUserGroup::whereIn('iAutoID', $aGroupID)->get()->toArray();
                $aGroupInfo = Tools::useFieldAsKey($aGroupInfo, 'iAutoID');
            }

            $aResult['data'] = array_map(function($aItem) use ($aGroupInfo, $aUserInfo){
                $aData = array_only($aItem, ['iUserID', 'sGroupName', 'iPrepend']);
                if(isset($aGroupInfo[$aItem['iGroupID']])) {
                    $aData['sGroupType'] = self::$aGroupType[$aGroupInfo[$aItem['iGroupID']]['iType']];
                }
                if(isset($aUserInfo[$aItem['iUserID']])) {
                    $aData['sName'] = $aUserInfo[$aItem['iUserID']]['sName'];
                }
                $aData['sExpireTime'] = date('Y-m-d', $aItem['iExpireTime']);
                $aData['sCreateTime'] = date('Y-m-d H:i:s', $aItem['iCreateTime']);
                $aData['sUpdateTime'] = date('Y-m-d H:i:s', $aItem['iUpdateTime']);
                return $aData;
            }, $aResult['data']);
        }
        return Response::mobi($aResult);
    }

    /**
     * 设置过期时间
     * @param $aParam
     * @return mixed
     */
    public static function setExpireTime($aParam)
    {
        if($aParam['iUserGroupType'] == self::USER_GROUP_MAIN) {
            return Response::exceptionMobi(new MobiException('MAIN_GROUP_CANNOT_EXPIRE'));
        }
        $aUserID = array_unique(array_filter(explode(',', $aParam['sUserID'])));
        if(!$aUserID) {
            return Response::exceptionMobi(new MobiException('USER_IS_EMPTY'));
        }
        $mResult = UserGroup::where('iGroupType', $aParam['iUserGroupType'])
            ->where('iGroupID', $aParam['iGroupID'])
            ->whereIn('iUserID', $aUserID)
            ->update(['iExpireTime' => strtotime($aParam['sExpireTime'])]);
        if(!$mResult) {
            return Response::exceptionMobi(new MobiException('UPDATE_ERROR'));
        }
        return Response::mobi([]);
    }

    /**
     * 设置过期时间
     * @param $aParam
     * @return mixed
     */
    public static function mergePerm($aParam)
    {
        if($aParam['iUserGroupType'] == self::USER_GROUP_MAIN) {
            return Response::exceptionMobi(new MobiException('MAIN_GROUP_CANNOT_MERGE'));
        }
        $aUserID = array_unique(array_filter(explode(',', $aParam['sUserID'])));
        if(!$aUserID) {
            return Response::exceptionMobi(new MobiException('USER_IS_EMPTY'));
        }
        $mResult = UserGroup::where('iGroupType', $aParam['iUserGroupType'])
            ->where('iGroupID', $aParam['iGroupID'])
            ->whereIn('iUserID', $aUserID)
            ->update(['iPrepend' => intval($aParam['iMergePerm'])]);
        if(!$mResult) {
            return Response::exceptionMobi(new MobiException('UPDATE_ERROR'));
        }
        return Response::mobi([]);
    }

    public static function delUserGroup($aParam)
    {
        $aUserID = array_unique(array_filter(explode(',', $aParam['sUserID'])));
        if(!$aUserID) {
            return Response::exceptionMobi(new MobiException('USER_IS_EMPTY'));
        }
        if($aParam['iUserGroupType'] == self::USER_GROUP_MAIN) {
            $aResult = User::where('iGroupID', $aParam['iGroupID'])
                ->whereIn('iAutoID', $aUserID)
                ->update(['iGroupID' => 0, 'sGroupName' => '']);
        } else {
            $aResult = UserGroup::where('iGroupID', $aParam['iGroupID'])
                ->where('iGroupType', $aParam['iUserGroupType'])
                ->whereIn('iUserID', $aUserID)
                ->delete();
        }
        if(!$aResult) {
            return Response::exceptionMobi(new MobiException('DELETE_ERROR'));
        }
        return Response::mobi([]);
    }
}