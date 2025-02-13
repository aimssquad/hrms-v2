<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveApply;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\User;
use App\Models\MobileMenu;
use App\Models\Registration;
use App\Models\MobileOrganizationMenu;
use App\Models\mobileMenu\MobileEmployeeMenu;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;

class MobileMenuController extends Controller
{
    public function getMobileMenu(Request $request)
    {
        try {
            if (auth()->check()) {
                $employeeId = auth()->user()->emid;
                $org = Registration::where('reg', $employeeId)->first();
                if (!$org) {
                    return Helper::rjd("Organization not found", 0, []);
                }
                $organization_id = $org->id;

                $menus = MobileOrganizationMenu::where('organization_id', $organization_id)
                    ->where('status', 1)
                    ->with('menu') // Ensure related menu data is loaded
                    ->get();

                $assignedMenus = MobileEmployeeMenu::where('organization_id', $organization_id)
                    ->pluck('menu_id')
                    ->toArray();

                $filteredMenus = $menus->filter(function ($menu) use ($assignedMenus) {
                    return in_array($menu->menu_id, $assignedMenus);
                });

                if ($filteredMenus->isEmpty()) {
                    return Helper::rjd("No assigned menus found", 0, []);
                }
                $menuIds = $filteredMenus->pluck('menu_id')->toArray();
                $data = MobileMenu::whereIn('id', $menuIds)->get();
                $data->transform(function ($item) {
                    return collect($item)->map(function ($value) {
                        return $value === null ? "" : $value;
                    });
                });
                //dd($data);
                $message = "Data retrieved successfully";
                return Helper::rjd($message, 1, $data);
            } else {
                return Helper::rjd("Something went wrong", 0, []);
            }
        } catch (Exception $e) {
            return Helper::rjd("Server Error: " . $e->getMessage(), 500);
        }
    }

} //End class
