<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\MobileMenu;
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

}
