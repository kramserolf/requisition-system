<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use Illuminate\Support\Facades\DB;
use DataTables;

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
                                ->select('r.id', 'i.item_name', 'r.quantity', 'r.quantity_type', 'r.status', 'r.name', 'r.department', 'r.recommending_status', 'r.approval_status')
                                ->get();
            return DataTables::of($requisition)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-success btn-sm approveRequisition"><i class="bi-check-lg"></i> </a> ';
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
        $request->validate([
            'inventory_id' => 'required',
            'quantity' => 'required|numeric',
            'quantity_type' => 'required',
            'department' => 'required',
            'name' => 'required|string|min:6',
        ]);

        $requisition = Requisition::create([
            'inventory_id' => $request->inventory_id,
            'quantity' => $request->quantity,
            'quantity_type' => $request->quantity_type,
            'department' => $request->department,
            'name' => $request->name,
        ]);
        
        return response()->json(['success'=> 'Requisition added successfully.']);
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
}
