<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use Illuminate\Support\Facades\DB;
use DataTables;
use Carbon\Carbon;

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
                                ->select('r.id', 'i.item_name', 'r.quantity', 'r.status', 'r.name', 'r.department', 'r.recommending_status', 'r.approval_status', 'r.status_no')
                                ->get();
            return DataTables::of($requisition)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm viewRequisition"><i class="bi-eye"></i> </a> ';
                        $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteRequisition"><i class="bi-trash"></i> </a>';
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
        $request->validate([
            'status' => 'required'
        ]);

        if($request->ajax()){
            if($request->status == 'released'){
                DB::table('requisitions as r')
                    ->leftJoin('inventories as i', 'r.inventory_id', 'i.id')
                    ->where('r.id', $request->id)
                    ->update([
                        'released_date' => Carbon::now()->toDateString(),
                        'i.quantity' => DB::raw('i.quantity - r.quantity')
                    ]);
                return response()->json(['success' => 'Updated Successfully']);
            } else{
                DB::table('requisitions')
                        ->where('id', $request->id)
                        ->update(['status' => $request->status]);
                return response()->json(['success' => 'Updated Successfully']);
            }

        }

    }

    public function vpUpdate(Request $request)
    {
        $request->validate([
            'status' => 'required'
        ]);

        if($request->ajax()){
            DB::table('requisitions')
                        ->where('id', $request->id)
                        ->update(['recommending_status' => $request->status]);
            return response()->json(['success' => 'Updated Successfully']);
        }

    }

    
    public function presidentUpdate(Request $request)
    {
        $request->validate([
            'status' => 'required'
        ]);

        if($request->ajax()){
            DB::table('requisitions')
                        ->where('id', $request->id)
                        ->update([
                            'approval_status' => $request->status, 
                        ]);
            return response()->json(['success' => 'Updated Successfully']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Requisition::where('id', $request->id)
                    ->delete();
    }

    public function viewStatus(Request $request)
    {
        if($request->ajax()){
            $requisition = DB::table('requisitions as r')
                                ->leftJoin('inventories as i', 'r.inventory_id', 'i.id', 'i.quantity_type')
                                ->select('r.id', 'i.item_name', 'r.quantity', 'r.status', 'r.name', 'r.department', 'r.recommending_status', 'r.approval_status', 'r.status_no', 'i.quantity_type')
                                ->where('r.id', $request->id)
                                ->first();

        }
        return response()->json($requisition);
    }


    
    public function vpRequisitionIndex(Request $request)
    {
        $requisition = [];
        if($request->ajax()){
            $requisition = DB::table('requisitions as r')
                                ->leftJoin('inventories as i', 'r.inventory_id', 'i.id')
                                ->select('r.id', 'i.item_name', 'r.quantity', 'r.status', 'r.name', 'r.department', 'r.recommending_status', 'r.approval_status', 'r.status_no')
                                ->get();
            return DataTables::of($requisition)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm viewRequisition"><i class="bi-eye"></i> </a> ';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.requisition2', [
            'requisition' => $requisition
        ]);
    }
    public function presidentRequisitionIndex(Request $request)
    {
        $requisition = [];
        if($request->ajax()){
            $requisition = DB::table('requisitions as r')
                                ->leftJoin('inventories as i', 'r.inventory_id', 'i.id')
                                ->select('r.id', 'i.item_name', 'r.quantity', 'r.status', 'r.name', 'r.department', 'r.recommending_status', 'r.approval_status', 'r.status_no')
                                ->get();
            return DataTables::of($requisition)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm viewRequisition"><i class="bi-eye"></i> </a> ';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.requisition3', [
            'requisition' => $requisition
        ]);
    }
}
