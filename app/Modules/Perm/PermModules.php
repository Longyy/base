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
use App\Models\Perm\CommonRoleUserGroupRelation;
use DB;
use Request;
use CustomAuth;
use Route;

class PermModules
{
    private static $aPermMap = [
        self::PERM_TYPE_R => ['index', 'show'],
        self::PERM_TYPE_C => ['create', 'store'],
        self::PERM_TYPE_U => ['edit', 'update'],
        self::PERM_TYPE_D => ['destroy'],
    ];
    private static $aActionMap = [
        'index'   => self::PERM_TYPE_R,
        'show'    => self::PERM_TYPE_R,
        'create'  => self::PERM_TYPE_C,
        'store'   => self::PERM_TYPE_C,
        'edit'    => self::PERM_TYPE_U,
        'update'  => self::PERM_TYPE_U,
        'destroy' => self::PERM_TYPE_D,
    ];
    const PERM_TYPE_R = 1;
    const PERM_TYPE_C = 2;
    const PERM_TYPE_U = 4;
    const PERM_TYPE_D = 8;
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
        if(is_array($aMainMenu)) {
            $aBusinessType = CommonBusinessTypeModules::getBusinessType();
            $sPathKey = CommonMenuModules::getPathKey();
            $sRoutes = Tools::getCurrentRoute();
            foreach($aMainMenu as &$aVal) {
                $sDomain = isset($aBusinessType[$aVal['iBusinessType']]) ? $aBusinessType[$aVal['iBusinessType']]['sDomain']
                    : Tools::getDomain();
                $aVal['sUrl'] = sprintf('%s://%s/%s%s', 'http', $sDomain, $aVal[$sPathKey], $aVal['sParam']);
//                $aVal['iActive'] = sprintf('%s@%s', )
            }
            unset($aVal);
        }
/*
        // 取该用户组下所有resource id
        $aPermInfo = DB::table('common_usergroup_perm')
            ->leftJoin('common_perm', 'common_usergroup_perm.iPermID', '=', 'common_perm.iAutoID')
            ->leftJoin('common_perm_resource', 'common_perm_resource.iPermID', '=', 'common_perm.iAutoID')
            ->where('common_usergroup_perm.iGroupID', $iUserGroupID)
            ->where('common_usergroup_perm.iPermType', 1)
            ->where('common_usergroup_perm.iValue', 2)
            ->where('common_perm.iHasReource', 2)
            ->select('common_perm_resource.*')
            ->get();
        $aAllMenuInfo = [];
        if(!empty($aPermInfo)) {
            $aResourceID = Tools::getFieldValues($aPermInfo, 'iAutoID');
            // 取叶子菜单
            $aMenuInfo = CommonMenu::select('iAutoID', 'sRelation')
                ->where('iType', 2)
                ->where('iLeaf', 2)
                ->where('iShow', 2)
                ->whereIn('iResourceID', $aResourceID)
                ->get()
                ->toArray();

            $aPath = Tools::getFieldValues($aMenuInfo, 'sRelation');

            // 取所有菜单项
            $aAllPath = [];
            foreach($aPath as $sValue) {
                $aAllPath = array_merge($aAllPath,
                    array_filter(explode(',', $sValue))
                );
            }
            $aAllPath = array_unique($aAllPath);
            $aAllMenuInfo = CommonMenu::select('*')
                ->whereIn('iAutoID', $aAllPath)
                ->orderBy('iLevel', 'asc')
                ->orderBy('iOrder', 'asc')
                ->get()
                ->toArray();
            $aAllMenuInfo = Tools::useFieldAsKey($aAllMenuInfo, 'iAutoID');
            $aActivePathID = [];

            // 构建菜单链接
            foreach($aAllMenuInfo as &$aInfo) {
                $aInfo['sUrl'] = $aInfo['sParam'] ? $aInfo['sWebPath'] . '?' . http_build_query($aInfo['sParam']) : $aInfo['sWebPath'];
                if(trim($aInfo['sWebPath'], '/') == Request::path()) {
                    $aActivePathID = explode(',', trim($aInfo['sRelation'], ','));
                }
                if(Request::path() == 'backend') {
                    $aActivePathID = [1,2,3];
                }
            }
            unset($aInfo);

            // 构建菜单路径及面包屑
            $aBreadMenu = [];
            foreach($aActivePathID as $iVal) {
                if(isset($aAllMenuInfo[$iVal])) {
                    $aAllMenuInfo[$iVal]['iActive'] = 1;
                    $aBreadMenu[] = [
                        'title' => $aAllMenuInfo[$iVal]['sName'],
                        'link' => $aAllMenuInfo[$iVal]['sUrl'],
                        'level' => $aAllMenuInfo[$iVal]['iLevel'],
                    ];
                }
            }
        }
*/
        $aResult = [
            'aBreadMenu' => !empty($aBreadMenu) ? $aBreadMenu : [],
            'aMainMenu' => !empty($aMainMenu) ? $aMainMenu : [],
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
        if(! isset(self::$aActionMap[$sAction])) {
            return false;
        }
        $aResource = CommonResourceModules::getResourceByController($sController);
        if(!$aResource) {
            return false;
        }
        $aRoleID = self::getUserRole();


    }



}