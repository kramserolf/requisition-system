<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Requisition;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
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
        $inventory = Inventory::get();

        return view('request-form', compact('inventory'));
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
                            ->select('r.*', 'i.item_name')
                            ->where('status_no', $request->tracking)
                            ->get();
            $tracking = $trackingObject->toArray();
            return response()->json(['message' => $tracking, 'status' => true]);
        } else{
            
            return response()->json(['message' => $trackingStatus, 'status' => false]);
        }

    }
}
