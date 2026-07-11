<?php

namespace App\Helpers;

use DB;

class PermissionHelper
{
    public static function hasPermission(

        $employeeId,

        $permissionName,

        $projectId,

        $workItemId = null,

        $emid = null
    ) {

        /*
        |--------------------------------------------------------------------------
        | GET USER ROLE IDS
        |--------------------------------------------------------------------------
        */

        $rolesQuery = DB::table('work_item_user_roles')

            ->where('employee_id', $employeeId)

            ->where('project_id', $projectId);

        /*
        |--------------------------------------------------------------------------
        | EMID CHECK
        |--------------------------------------------------------------------------
        */

        if ($emid) {

            $rolesQuery->where('emid', $emid);
        }

        /*
        |--------------------------------------------------------------------------
        | WORK ITEM ACCESS
        |--------------------------------------------------------------------------
        */

        if ($workItemId) {

            $rolesQuery->where(function ($query) use ($workItemId) {

                $query->where('work_item_id', $workItemId)

                    // project level role
                    ->orWhereNull('work_item_id');
            });
        }

        $roleIds = $rolesQuery

            ->pluck('project_role_id')

            ->toArray();

        if (empty($roleIds)) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK ROLE HAS PERMISSION
        |--------------------------------------------------------------------------
        */

        $hasPermission = DB::table('project_role_permissions as prp')

            ->join(
                'project_permissions as pp',
                'pp.id',
                '=',
                'prp.project_permission_id'
            )

            ->whereIn('prp.project_role_id', $roleIds)

            ->where('pp.name', $permissionName)

            ->exists();

        return $hasPermission;
    }
}