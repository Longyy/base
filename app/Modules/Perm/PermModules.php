<?php
namespace App\Modules\Perm;
/**
 * Created by PhpStorm.
 * UserModules: Administrator
 * Date: 2017/3/14
 * Time: 22:10
 */
use App\Models\Perm\CommonMenu;
use App\Http\Helpers\Tools;
use App\Models\Perm\CommonRolePerm;
use App\Models\Perm\CommonRoleUserGroupRelation;
use DB;
use Request;
use CustomAuth;
use Route;

class PermModules
{
    private static $aPermMap = [
        self::PERM_TYPE_R => ['index', 'show', 'getList'],
        self::PERM_TYPE_C => ['create', 'store'],
        self::PERM_TYPE_U => ['edit', 'update'],
        self::PERM_TYPE_D => ['destroy'],
    ];
    private static $aActionMap = [
        'index'   => self::PERM_TYPE_R,
        'show'    => self::PERM_TYPE_R,
        'getList' => self::PERM_TYPE_R,
        'create'  => self::PERM_TYPE_C,
        'store'   => self::PERM_TYPE_C,
        'edit'    => self::PERM_TYPE_U,
        'update'  => self::PERM_TYPE_U,
        'destroy' => self::PERM_TYPE_D,
    ];
    const PERM_TYPE_R = 1; // 0001
    const PERM_TYPE_C = 2; // 0010
    const PERM_TYPE_U = 4; // 0100
    const PERM_TYPE_D = 8; // 1000
    /**
     * 取菜单
     * @param $iUserGroupID
     */
    public static function getPageMenu()
    {
        $aMainMenu = [];
        $aRoleID = self::getUserRole();
        // 取菜单
        $aMenuID = CommonRoleMenuModules::getMenuIDByRoleIDs($aRoleID);
        // 取菜单信息
        $aMainMenu = CommonMenuModules::getMenuInfoByID($aMenuID);
        // 处理菜单
        $aActivePath = [];
        if(is_array($aMainMenu)) {
            $aBusinessType = CommonBusinessTypeModules::getBusinessType();
            $sPathKey = CommonMenuModules::getPathKey();
            foreach($aMainMenu as &$aVal) {
                $sDomain = isset($aBusinessType[$aVal['iBusinessType']]) ? $aBusinessType[$aVal['iBusinessType']]['sDomain']
                    : Tools::getDomain();
                $sPath = sprintf('%s://%s/%s', 'http', $sDomain, trim($aVal[$sPathKey], '/') );
                $aVal['sUrl'] = sprintf('%s%s', $sPath, $aVal['sParam']);
                if(Request::url() == $sPath) {
                    $aVal['iActive'] = 1;
                    $aActivePath = explode(',', trim($aVal['sRelation'], ','));
                } else {
                    $aVal['iActive'] = 0;
                }
            }
            unset($aVal);

            // 设置active menu
            $aMainMenu = array_map(function($aVal) use ($aActivePath) {
                $aVal['iActive'] = in_array($aVal['iAutoID'], $aActivePath) ? 1 : 0;
                return $aVal;
            }, $aMainMenu);
            // 设置面包屑导航
            $aBreadMenu = array_where($aMainMenu, function($sKey, $aVal) use ($aActivePath) {
                return $aVal['iActive'] ? true : false;
            });
        }
        $aResult = [
            'aBreadMenu' => !empty($aBreadMenu) ? $aBreadMenu : [],
            'aMainMenu' => !empty($aMainMenu) ? $aMainMenu : [],
            'aMenuLevel' => $aActivePath,
        ];

        return $aResult;
    }

    public static function getUserRole()
    {
        // 取用户组
        $aUserGroupID = CustomAuth::getAllPermGroupIDs();
        // 取角色
        $aRoleID = CommonRoleUserGroupRelationModules::getRoleIDByGroupIDs($aUserGroupID);
        return $aRoleID;
    }

    public static function check($sResourceUrl)
    {
        list($sController, $sAction) = explode('@', $sResourceUrl);
        $sTempAction = ! isset(self::$aActionMap[$sAction]) ? $sAction : '';
        if(! ($aResource = CommonResourceModules::getResourceByController($sController, $sTempAction))) {
            return true;
        }
        $aPerm = self::getPerm($aResource['iAutoID'], self::getUserRole());
        // 用户所属的多个角色都有该资源的权限，取其大者
        if($sTempAction && count($aPerm)) {
            return true;
        }
        $bHasPerm = false;
        foreach($aPerm as $aVal) {
            if(self::hasPerm($aVal['iPerm'], self::$aActionMap[$sAction])) {
                $bHasPerm = true;
            }
        }
        return $bHasPerm;
    }

    /**
     * 根据资源和角色获取权限信息
     * @param $iResourceID
     * @param $aRoleID
     * @return array
     */
    public static function getPerm($iResourceID, $aRoleID)
    {
        $oPerm = CommonRolePerm::where('iResourceID', $iResourceID)
            ->whereIn('iRoleID', $aRoleID)
            ->get();
        return count($oPerm) ? $oPerm->toArray() : [];
    }

    /**
     * 鉴权
     * @param $iTotalPerm
     * @param $iCurrentPerm
     * @return bool
     */
    public static function hasPerm($iTotalPerm, $iCurrentPerm)
    {
//        授权值 = 授权码 & 授权值
        return (intval($iTotalPerm) & intval($iCurrentPerm)) == $iCurrentPerm ? true : false;
    }

}