<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

/**
 * menu service
 * Class MenuService
 * @package app\service\service
 */
class MenuService
{
    /**
     * @desc search menu list to view
     * @param int $byCache
     * @param int $doBuild
     * @return array
     */
    public function roleMenus(int $byCache, int $doBuild): array
    {
        $roleIds = session('admin.role_ids');
        $adminId = session('admin.id');

        if ($byCache) {
            $cacheMenus = Cache::get('navbarMenus_' . $adminId);
            if (!empty($cacheMenus)) return $cacheMenus;
        }

        $roleIds = empty($roleIds) ? [] : explode(",", $roleIds);

        if (in_array(1, $roleIds)) {
            // search all menus for super admin
            $menuList = $this->allMenus();
        } else {
            // search menu list for normal user
            $menuList = $this->getMenuData($roleIds);
        }

        if ($doBuild) {
            $menuList = $this->buildMenuTree(0, $menuList);
        }

        if ($byCache) {
            Cache::put('navbarMenus_' . $adminId, $menuList);
        }

        return $menuList;
    }

    /**
     * @desc get menu data list
     * @param array $roleIds
     * @return array
     */
    public function getMenuData(array $roleIds = []): array
    {
        if (empty($roleIds)) {
            return [];
        }

        $fields = [
            'menu_node.id',
            'menu_node.pid',
            'menu_node.sort',
            'menu_node.level',
            'menu_node.title',
            'menu_node.url'
        ];

        $menuNodeList = DB::table('admin_menu_node as menu_node')
            ->join('admin_role_nodes as role_nodes', 'menu_node.id', '=', 'role_nodes.node_id')
            ->select($fields)
            ->where([
                    ['menu_node.is_show', '=', '1'],
                    ['menu_node.is_delete', '=', 0]]
            )->whereIn('role_nodes.role_id', $roleIds)
            ->orderBy('sort')
            ->get()->map(function ($value) {
                return (array)$value;
            });

        return $menuNodeList ? $menuNodeList->toArray() : [];
    }

    /**
     * @desc get all valid menus
     * @return array
     */
    public function allMenus(): array
    {
        $fields = [
            'menu_node.id',
            'menu_node.pid',
            'menu_node.sort',
            'menu_node.level',
            'menu_node.title',
            'menu_node.url'
        ];

        $menuNodeList = DB::table('admin_menu_node as menu_node')
            ->select($fields)
            ->where([
                    ['menu_node.is_show', '=', '1'],
                    ['menu_node.is_delete', '=', 0]]
            )->orderBy('sort')
            ->get()->map(function ($value) {
                return (array)$value;
            });

        return $menuNodeList ? $menuNodeList->toArray() : [];
    }

    private function buildMenuTree(int $pid, array $menuList): array
    {
        $treeList = [];
        foreach ($menuList as $v) {
            if ($pid == $v['pid']) {
                $child = $this->buildMenuTree($v['id'], $menuList);
                $v['child'] = [];
                if (!empty($child)) {
                    $v['child'] = $child;
                }
                if (!empty($v['url']) || !empty($v['child'])) {
                    $treeList[] = $v;
                }
            }
        }

        // sort menu list
        array_multisort(array_column($treeList, 'sort'), SORT_ASC, $treeList);

        return $treeList;
    }

    /**
     * @desc check whether user can access to this route path
     * @param $routePath
     * @return boolean
     */
    public function checkNodeAuth($routePath): bool
    {
        $routePath = rtrim($routePath, '/');
        $roleMenus = $this->roleMenus(0, 0);
        $authMenuUrls = array_filter(array_unique(array_column($roleMenus, 'url')));

        if (!in_array($routePath, $authMenuUrls)) {
            return false;
        } else {
            return true;
        }
    }
}
