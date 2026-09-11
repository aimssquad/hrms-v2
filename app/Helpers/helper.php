<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;

class Helper
{
    public static function getSidebarItems()
    {
        $email = Session::get("emp_email");
        $user_type = Session::get("user_type");
        $sidebarItems = [];
        
        if ($user_type == "employer") {
            //dd('okk');
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

            if ($Roledata) {
                $Roles_auth = DB::table("othorized_organization_module")
                    ->where("employee_id", "=", $Roledata->reg)
                    ->get();

                foreach ($Roles_auth as $role) {
                    $sidebarItems[] = [
                        'module_name' => $role->module_name
                        
                        //'module_display_name' => $role->module_display_name // Assuming you have a display name
                    ];
                }
            }
        } else {
            //dd('noy');
            $users_id = Session::get("users_id");
            $dtaem = DB::table("users")
                ->where("id", "=", $users_id)
                ->first();    
            //$organization_id = $dtaem->emid;
            //dd($emid);
            if ($dtaem) {       
                $Roles_auth = DB::table('employee_permissions')
                    ->join('sub_menu', 'employee_permissions.submenu_id', '=', 'sub_menu.id')
                    ->select('employee_permissions.*', 'sub_menu.submenu_name', 'sub_menu.submenu_url')
                    ->where('employee_permissions.employee_id', '=', $dtaem->employee_id)
                    ->groupBy('employee_permissions.module_name', 'employee_permissions.submenu_id')
                    ->orderBy('employee_permissions.submenu_id', 'asc')
                    ->get();
                // echo $Roles_auth;
               
                // Group submenus by module name
                $sidebarItems = [];
                foreach ($Roles_auth as $role) {
                    $sidebarItems[$role->module_name][] = [
                        'submenu_name' => $role->submenu_name,
                        'submenu_id' => $role->submenu_id,
                        'submenu_url' => $role->submenu_url,
                        'can_add' => $role->can_add,
                        'can_edit' => $role->can_edit,
                        'can_delete' => $role->can_delete,
                        'can_export' => $role->can_export,
                        'can_import' => $role->can_import,
                        'emid' => $role->org_id,
                    ];
                }
            }
        }
          //dd($sidebarItems);
        return $sidebarItems;
    }


    public static function getEmidFromSidebarItems()
    {
        $sidebarItems = self::getSidebarItems(); // Assuming this method fetches sidebar items
        foreach ($sidebarItems as $key => $items) {
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (isset($item['emid'])) {
                        return $item['emid']; // Return the first found emid
                    }
                }
            }
        }
        return null; // Return null if no emid is found
    }

    // For defult image

    public static function getImageUrl($imagePath, $defaultImage = 'storage/default_image.png') {
        return !empty($imagePath) ? asset("storage/app/public/{$imagePath}") : asset($defaultImage);
    }

    public static function cachedTrans($text, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $cacheKey = "trans_{$locale}_" . md5($text);

        return Cache::rememberForever($cacheKey, function () use ($text, $locale) {
            return GoogleTranslate::trans($text, $locale);
        });
    }

    //google translation error thats why i commented it out the above function and added below function
    // public static function cachedTrans($text, $locale = null)
    // {
    //     $locale = $locale ?? app()->getLocale();

    //     // No need to translate if source and target language are the same
    //     if ($locale === 'en') {
    //         return $text;
    //     }

    //     $cacheKey = 'trans_' . $locale . '_' . md5($text);

    //     return Cache::rememberForever($cacheKey, function () use ($text, $locale) {
    //         try {
    //             return GoogleTranslate::trans($text, $locale);
    //         } catch (\Throwable $e) {

    //             \Log::warning('Google Translate failed', [
    //                 'text' => $text,
    //                 'locale' => $locale,
    //                 'error' => $e->getMessage(),
    //             ]);

    //             // If Google Translate fails, show original text
    //             return $text;
    //         }
    //     });
    //}
    



    


}




?>