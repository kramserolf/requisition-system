<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\ReturnItem;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class ReturnItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requisitions = DB::table('requisitions as r')
                                ->leftJoin('inventories as i', 'r.inventory_id', 'i.id')
                                ->select('r.status_no', 'r.id as req_id', 'i.item_name', 'r.quantity', 'i.quantity_type')
                                ->get();
        $return_items = [];
        if($request->ajax()){
            $return_items = DB::table('return_items as i')
                                ->leftJoin('requisitions as r', 'i.requisition_id', 'r.id')
                                ->leftJoin('inventories as n', 'r.inventory_id', 'n.id')
                                ->select(
                                    'i.*', 
                                    'r.status_no', 
                                    'r.released_date',
                                    'r.name',
                                    'n.item_name',
                                    'r.department',
                                    DB::raw('DATE_FORMAT(i.date_returned, \'%M %d, %Y\') as date_returned')
                                    )
                                ->orderBy('created_at', 'desc')
                                ->get();
            return DataTables::of($return_items)
                    ->addIndexColumn()
                    ->make(true);
        }
        return view('admin.return_items', compact('return_items', 'requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'requisition' => 'required',
            'issue' => 'required|string|max:255',
            'date_returned' => 'required'
        ]);

        ReturnItem::create([
            'requisition_id' => $request->requisition,
            'issue' => $request->issue,
            'date_returned' => $request->date_returned,
            'remarks' => $request->remarks
        ]);

        return response()->json(['success' => 'Return Items successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
