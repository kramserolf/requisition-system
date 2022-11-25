<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;


class InventoryController extends Controller
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
        $categories = Category::all();
        $inventory = [];
        if($request->ajax()){
            $inventory = DB::table('inventories as i')
                                ->leftJoin('categories as c', 'i.category_id', 'c.id')
                                ->select(
                                    'i.*', 
                                    'c.title', 
                                    DB::raw('DATE_FORMAT(i.date_acquired, \'%M %d, %Y\') as date_acquired')
                                    )
                                ->orderBy('created_at', 'desc')
                                ->get();
            return DataTables::of($inventory)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        // $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editInventory"><i class="bi-pencil-square"></i> </a> ';
                        $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteInventory"><i class="bi-trash"></i> </a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.inventories', compact('inventory', 'categories'));
    }

    public function vpIndex(Request $request)
    {
        $inventory = [];
        if($request->ajax()){
            $inventory = DB::table('inventories as i')
                            ->leftJoin('categories as c', 'i.category_id', 'c.id')
                            ->select(
                                'i.*', 
                                'c.title', 
                                DB::raw('DATE_FORMAT(i.date_acquired, \'%M %d, %Y\') as date_acquired')
                                )
                            ->orderBy('created_at', 'desc')
                            ->get();
            return DataTables::of($inventory)
                    ->addIndexColumn()
                    ->make(true);
        }
        return view('admin.inventories2', compact('inventory'));
    }
    
    public function presidentIndex(Request $request)
    {
        $inventory = [];
        if($request->ajax()){
            $inventory = DB::table('inventories as i')
                            ->leftJoin('categories as c', 'i.category_id', 'c.id')
                            ->select(
                                'i.*', 
                                'c.title', 
                                DB::raw('DATE_FORMAT(i.date_acquired, \'%M %d, %Y\') as date_acquired')
                                )
                            ->orderBy('created_at', 'desc')
                            ->get();
            return DataTables::of($inventory)
                    ->addIndexColumn()
                    ->make(true);
        }
        return view('admin.inventories3', compact('inventory'));
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
            'category' => 'required',
            'item_name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required',
            'quantity_type' => 'required',
            'date_acquired' => 'required'
        ]);

        Inventory::create([
            'item_name' => $request->item_name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'quantity_type' => $request->quantity_type,
            'date_acquired' => $request->date_acquired,
            'category_id' => $request->category,
        ]);

        return response()->json(['success'=> 'Item added successfully.']);
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
    public function destroy(Request $request)
    {
        Inventory::where('id', $request->id)
                    ->delete();

    }
}
