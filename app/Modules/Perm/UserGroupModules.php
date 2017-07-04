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
use DB;
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

    public static function batchSetUserGroup($aParam)
    {
        $aUserID = array_filter(array_unique(explode(',', $aParam['sUserID'])));
        // 用户必须存在
        $iUserCount = User::whereIn('iAutoID', $aUserID)->count();
        if($iUserCount != count($aUserID)) {
            return Response::exceptionMobi(new MobiException('ALL_USER_MUST_EXIST'));
        }
        switch($aParam['iUserGroupType']) {
            case self::USER_GROUP_MAIN:
                $iUserCount = User::whereIn('iAutoID', $aUserID)
                    ->where('iGroupID', $aParam['addToGroupID'])
                    ->count();
                if($iUserCount) {
                    return Response::exceptionMobi(new MobiException('SOME_USER_HAS_HOLD_THE_GROUP'));
                }
                $oUserGroup = CommonUserGroup::find($aParam['addToGroupID']);
                if($oUserGroup == null) {
                    return Response::exceptionMobi(new MobiException('USER_GROUP_NOT_EXIST'));
                }
                $mResult = User::whereIn('iAutoID', $aUserID)
                    ->update(['iGroupID' => $aParam['addToGroupID'], 'sGroupName' => $oUserGroup->sName]);
                if(!$mResult) {
                    return Response::exceptionMobi(new MobiException('ADD_ERROR'));
                }
                // 取消用户对该用户组在其他场景的权限
                $mDelResult = UserGroup::whereIn('iUserID', $aUserID)
                    ->where('iGroupID', $aParam['addToGroupID'])
                    ->delete();
                if(!$mDelResult){
                    return Response::exceptionMobi(new MobiException('DEL_OLD_RELATION_ERROR'));
                }
                break;
            case self::USER_GROUP_TEMP:
            case self::USER_GROUP_EXT:
                $iUserCount = UserGroup::where('iUserID', $aUserID)
                    ->where('iGroupID', $aParam['addToGroupID'])
                    ->count();
                if($iUserCount) {
                    return Response::exceptionMobi(new MobiException('SOME_USER_HAS_HOLD_THE_GROUP'));
                }
                // 用户的主用户组如果是该用户组，则报错
                $iUserMainCount = User::whereIn('iAutoID', $aUserID)
                    ->where('iGroupID', $aParam['addToGroupID'])
                    ->count();
                if($iUserMainCount) {
                    return Response::exceptionMobi(new MobiException('USER_MAIN_GROUP_HAS_CONTAINED'));
                }
                $oUserGroup = CommonUserGroup::find($aParam['addToGroupID']);
                if($oUserGroup == null) {
                    return Response::exceptionMobi(new MobiException('USER_GROUP_NOT_EXIST'));
                }
                $aData = array_map(function($iUserID) use ($oUserGroup, $aParam) {
                    return [
                        'iUserID' => $iUserID,
                        'iGroupType' => $aParam['iUserGroupType'],
                        'iGroupID' => $oUserGroup->iAutoID,
                        'sGroupName' => $oUserGroup->sName,
                    ];
                }, $aUserID);
                $mResult = DB::table('user_group')->insert($aData);
                if(!$mResult) {
                    return Response::exceptionMobi(new MobiException('ADD_ERROR'));
                }

                break;
            default:
                break;
        }
        return Response::mobi([]);
    }

    public static function getUserAllGroup($iUserID)
    {
        $aResult = [];
        // 取主用户组
        $oUser = User::find($iUserID);
        $aResult[self::USER_GROUP_MAIN][] = [
            'iGroupID' => $oUser->iGroupID,
            'sGroupName' => $oUser->sGroupName,
        ];

        // 取临时和扩展用户组(未过期)
        $oUserGroup = UserGroup::where('iUserID', $iUserID)
            ->where('iExpireTime', '>', time())
            ->get();

        foreach($oUserGroup as $aGroup) {
            $aResult[$aGroup->iGroupType][] = [
                'iGroupID' => $aGroup->iGroupID,
                'sGroupName' => $aGroup->sGroupName,
            ];
        }
        return Response::mobi($aResult);
    }
}