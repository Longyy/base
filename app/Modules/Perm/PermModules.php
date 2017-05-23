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
use DB;
use Request;

class PermModules
{
    /**
     * 取菜单
     * @param $iUserGroupID
     */
    public static function getPageMenu($iUserGroupID)
    {
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

        $aResult = [
            'aBreadMenu' => !empty($aBreadMenu) ? $aBreadMenu : [],
            'aMainMenu' => !empty($aAllMenuInfo) ? $aAllMenuInfo : [],
        ];

        return $aResult;
    }



}