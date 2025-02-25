<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingRule;
use App\Models\BillingItem;
use Session;
use Exception;
use DB;

class BillingItemController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'admin.billing_item';
        $this->_model       = new BillingItem();
    }

    // public function index()
    // {
    //     try{
    //         $email = Session::get('empsu_email');
    //         if(!empty($email)){
    //             $menus = MobileMenu::all();
    //             return view($this->_routePrefix .'.index', compact('menus'));
    //         } else {
    //             return redirect('superadmin');
    //         }
    //     } catch (Exception $e) {
    //         throw new \App\Exceptions\AdminException($e->getMessage());
    //     }
       
    // }
    // public function create(){
    //     try{
    //         $email = Session::get('empsu_email');
    //         if(!empty($email)){
    //             return view($this->_routePrefix .'.item');
    //         } else {
    //             return redirect('superadmin');
    //         }
    //     } catch (Exception $e) {
    //         throw new \App\Exceptions\AdminException($e->getMessage());
    //     }
    // }

    public function index()
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $items = BillingItem::all();
                return view($this->_routePrefix . '.index', compact('items'));
            } else {
                return redirect('superadmin');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    // CREATE: Show form for adding new item
    public function create()
    {
        //dd('okk');
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                return view($this->_routePrefix . '.item');
            } else {
                return redirect('superadmin');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    // STORE: Save new item
    public function store(Request $request)
    {
        $request->validate([
            'item_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:0,1',
        ]);

        BillingItem::create([
            'item_name'   => $request->item_name,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('billing_item.index')->with('success', 'Item added successfully.');
    }

    // EDIT: Show edit form
    public function edit($id)
    {
        $item = BillingItem::findOrFail($id);
        return view($this->_routePrefix . '.edit', compact('item'));
    }

    // UPDATE: Save changes
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:0,1',
        ]);

        $item = BillingItem::findOrFail($id);
        $item->update([
            'item_name'   => $request->item_name,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('billing_item.index')->with('success', 'Item updated successfully.');
    }

    // DELETE: Remove item
    public function destroy($id)
    {
        $item = BillingItem::findOrFail($id);
        $item->delete();

        return redirect()->route('billing_item.index')->with('success', 'Item deleted successfully.');
    }

} //End Class
