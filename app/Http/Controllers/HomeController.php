<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Requisition;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Laravel\Ui\Presets\React;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function request_form()
    {
        $inventory = Inventory::where('quantity', '>=', 1)
                        ->get();

        return view('request-form', compact('inventory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required',
            'quantity' => 'required',
            'department' => 'required',
            'name' => 'required|string|min:6',
        ]);

        $tracking_no = 'SJCBI-00'.rand(0, 999999);


        $items = explode(',', $request->hidden_item);
        
        $quantity = explode(',', $request->quantity);
      
        for($i = 0; $i < count($items, (int)$quantity); $i++){
            $requisition[] = [
                'inventory_id' => $items[$i],
                'quantity' => $quantity[$i],
                'department' => $request->department,
                'name' => $request->name,
                'status_no' => $tracking_no,
                'status' => 'pending'
            ];
        }

        $requisition = Requisition::insert($requisition);

        return response()->json(['tracking' => $tracking_no, 'message' => $requisition]);
    }

    public function trackStatus(Request $request)
    {
        $request->validate([
            'tracking' => 'required'
        ]);

        $trackingStatus = DB::table('requisitions')
                            ->where('status_no', $request->tracking)
                            ->exists();
        if($trackingStatus){
            $trackingObject = DB::table('requisitions as r')
                            ->leftJoin('inventories as i', 'r.inventory_id', 'i.id')
                            ->select('r.*', 'i.item_name', 'i.quantity_type as unit')
                            ->where('status_no', $request->tracking)
                            ->get();
            $tracking = $trackingObject->toArray();
            return response()->json(['message' => $tracking, 'status' => true]);
        } else{
            
            return response()->json(['message' => $trackingStatus, 'status' => false]);
        }

    }
}
