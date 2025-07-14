<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MobileMenu;
use App\Models\Registration;
use App\Models\MobileOrganizationMenu;
use App\Models\mobileMenu\MobileEmployeeMenu;
use App\Models\Admin\OrgAttendancePermission;
use App\Models\Admin\EmpPunchTypeMaster;
use Session;
use DB;
use Illuminate\Support\Str;

class OrgAttenPermissionController extends Controller
{
    public function index(){
        $results = DB::table('registration')
            ->where('status', '=', 'active')
            ->whereNull('org_code')
            ->get();
        foreach ($results as $res) {
            $res->punch_types = DB::table('org_attendance_permissions AS oap')
                ->join('emp_punch_type_masters AS ptm', 'ptm.id', '=', 'oap.punch_type_id')
                ->where('oap.emid', $res->reg)
                ->pluck('ptm.punch_type_name');
        }
        //dd($punch_type);
        return view('admin.attendance-permission.index',compact('results'));       
    }

    public function viewPermission(Request $request, $id){
        $data['orgDtl'] = DB::table('registration')->where('reg',$id)->first();
        $data['punch_type'] = DB::table('emp_punch_type_masters')->get();
        //dd($data['punch_type']);
        return view('admin.attendance-permission.org-permission',$data); 
    }

    public function saveEmpAttenPermission(Request $request)
    {
        //dd('okk');
        $request->validate([
            'emid' => 'required|exists:registration,reg',
            'punch_type_id' => 'required|array|min:1',
            'punch_type_id.*' => 'exists:emp_punch_type_masters,id',
            'default_punch_type_id' => 'required|exists:emp_punch_type_masters,id',
        ]);

        $emid = $request->input('emid');
        $punchTypes = $request->input('punch_type_id');
        $defaultType = $request->input('default_punch_type_id');

        // 1. Delete existing permissions for this org
        DB::table('org_attendance_permissions')->where('emid', $emid)->delete();

        // 2. Insert new permissions
        $insertData = [];

        foreach ($punchTypes as $typeId) {
            $insertData[] = [
                'emid' => $emid,
                'punch_type_id' => $typeId,
                'default_punch_type_id' => $defaultType,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('org_attendance_permissions')->insert($insertData);

        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }






}
