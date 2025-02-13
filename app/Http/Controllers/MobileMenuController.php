<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MobileMenu;
use App\Models\Registration;
use App\Models\MobileOrganizationMenu;
use App\Models\mobileMenu\MobileEmployeeMenu;
use Session;
use DB;
use Illuminate\Support\Str;



class MobileMenuController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'admin.mobile-menu';
        $this->_model       = new MobileMenu();
    }

    public function index()
    {
        $menus = MobileMenu::all();
        return view($this->_routePrefix .'.index', compact('menus'));
    }

    public function create(Request $request)
    {
        return view('admin/mobile-menu/menu');
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
        ]);
        $data = $request->all();
        $data['identifier'] = Str::slug($request->menu_name, '_');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('mobile-menus', 'public');
        }
        //dd($data);
        MobileMenu::create($data);
        return redirect()->route('mobile-menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit($id)
    {
        $menu = MobileMenu::findOrFail($id);
        return view($this->_routePrefix .'.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = MobileMenu::findOrFail($id);
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'url' => 'nullable|string|max:255',
            // 'type' => 'required|in:internal,external',
            'status' => 'required|in:active,inactive',
        ]);
        $data = $request->all();
        // if ($request->menu_name !== $menu->menu_name) {
        //     $identifier = Str::slug($request->menu_name, '_');
        //     $data['identifier'] = $identifier;
        // }
        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('mobile-menus', 'public');
        }
        $menu->update($data);
        return redirect()->route('mobile-menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy($id)
    {
        $menu = MobileMenu::findOrFail($id);
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();
        return redirect()->route('mobile-menus.index')->with('success', 'Menu deleted successfully.');
    }

    public function organization_menu(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $org = Registration::where('email', $email)->first(); // Use first() instead of get() to avoid array issues
            $organization_id = $org->id;
            $menus = MobileOrganizationMenu::where('organization_id', $organization_id)
                ->with('menu')
                ->where('status',1)
                ->get();
            $assignedMenus = MobileEmployeeMenu::where('organization_id', $organization_id)
                ->pluck('menu_id')
                ->toArray(); 
            $status = MobileEmployeeMenu::where('organization_id', $organization_id)
                ->value('status'); 
            //dd($menus);         
            return view('employeer.mobile-menu.org-mobile-menu', compact('menus', 'assignedMenus', 'status'));
        } else {
            return redirect('/');
        }
    }


    public function saveOrganizationMenu(Request $request)
    {
        $request->validate([
            'menu_ids' => 'array',
            'status' => 'required|integer|in:0,1'
        ]);
        $email = Session::get('emp_email');
        $reg_id = Registration::where('email', $email)->first();
        $organization_id = $reg_id->id;
        $user_id = User::where('email', $email)->first();
        $permission_by = $user_id->id;

        $selectedMenus = $request->input('menu_ids', []);
        $status = $request->input('status');

        $existingMenus = MobileEmployeeMenu::where('organization_id', $organization_id)
            ->pluck('menu_id')
            ->toArray();

        // **1. Insert new selections OR update status for existing records**
        foreach ($selectedMenus as $menu_id) {
            MobileEmployeeMenu::updateOrCreate(
                [
                    'menu_id' => $menu_id,
                    'organization_id' => $organization_id
                ],
                [
                    'permission_by' => $permission_by, 
                    'status' => $status // Update status even for existing records
                ]
            );
        }

        // **2. Remove unselected menus**
        MobileEmployeeMenu::where('organization_id', $organization_id)
            ->whereNotIn('menu_id', $selectedMenus)
            ->delete();

        return redirect()->back()->with('success', 'Menu permissions updated successfully.');
    }




   

  
    public function empMenu(Request $request)
    {
        $menus = MobileOrganizationMenu::with(['menu', 'organization'])->get(); 
        $groupedMenus = $menus->groupBy('organization_id');
        return view('admin.mobile-menu.org-menu', compact('groupedMenus'));
    }



    //-------------------------Super admin give menu for Organization ----------------

 
  

    public function menu(Request $request)
    {
        $organizations = Registration::where('status', 'active')
            ->where('verify', 'approved')
            ->with(['menus.menu']) 
            ->get();   
        return view('admin.mobile-menu.org-menu', compact('organizations'));
    }

    public function menuEdit($organization_id)
    {
        $email = Session::get('emp_email');
        $org = User::where('email',$email)->get();
        $organization_id = $organization_id;
        $menus = MobileMenu::all();
        $assignedMenus = MobileOrganizationMenu::where('organization_id', $organization_id)
            ->pluck('menu_id')
            ->toArray(); 
        $status = MobileOrganizationMenu::where('organization_id', $organization_id)
            ->value('status'); 
        //dd($menus);    
        return view('admin.mobile-menu.edit-org-menu', compact( 'menus','assignedMenus', 'status','organization_id'));
       
    }

    public function saveEmployeeMenu(Request $request)
    {
        $request->validate([
            'menu_ids' => 'array',
            'status' => 'required|integer|in:0,1'
        ]);
        $email = Session::get('empsu_email');;
       
        $org = User::where('email', $email)->first();
        $permission_by = $org->id;
        //dd($permission_by);
        $organization_id = $request->input('organization_id');
        $selectedMenus = $request->input('menu_ids', []);
        $status = $request->input('status');

        $existingMenus = MobileOrganizationMenu::where('organization_id', $organization_id)
            ->pluck('menu_id')
            ->toArray();

        // **1. Insert new selections OR update status for existing records**
        foreach ($selectedMenus as $menu_id) {
            MobileOrganizationMenu::updateOrCreate(
                [
                    'menu_id' => $menu_id,
                    'organization_id' => $organization_id
                ],
                [
                    'permission_by' => $permission_by, 
                    'status' => $status // Update status even for existing records
                ]
            );
        }

        // **2. Remove unselected menus**
        MobileOrganizationMenu::where('organization_id', $organization_id)
            ->whereNotIn('menu_id', $selectedMenus)
            ->delete();

        return redirect('superadmin/menus')->with('message', 'Menu permissions updated successfully.');
    }

 

  




}
