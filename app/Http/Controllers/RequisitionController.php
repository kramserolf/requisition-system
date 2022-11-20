<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\Tracking;
use Illuminate\Support\Facades\DB;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RequisitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requisition = [];
        if($request->ajax()){
            $requisition = DB::table('requisitions as r')
                                ->leftJoin('inventories as i', 'r.inventory_id', 'i.id')
                                ->select('r.id', 'i.item_name', 'r.quantity', 'r.status', 'r.name', 'r.department', 'r.recommending_status', 'r.approval_status')
                                ->get();
            return DataTables::of($requisition)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '                       <select class="form-select form-select-sm" aria-label="Default select example" name="search_by" id="search_by">
                        <option selected>Select action</option>
                        <option value="country">View Status</option>
                        <option value="name">Name</option>
                        </select>';
                        // $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteRequisition"><i class="bi-trash"></i> </a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.requisition', [
            'requisition' => $requisition
        ]);
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
        //
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
    public function update(Request $request)
    {
        $requisition = Requisition::where('id', $request->id)
                        ->first();
        $requisition->status = 'approved';
        $requisition->save();
        return response()->json(['success' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }


    // public function getUnit(Request $request)
    // {
    //     if($request->ajax()){
    //         $unit = DB::table('inventories')
    //                     ->where('id', $request->inventory_id)
    //                     ->first();
    //         $getunit = $unit->quantity_type;
    //         return response($getunit);
    //     }
    // }
}
