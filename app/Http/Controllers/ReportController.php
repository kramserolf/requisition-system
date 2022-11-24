<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $report = [];
        if($request->ajax()){
            $report = DB::table('requisitions as r')
                            ->leftJoin('inventories as i', 'r.inventory_id', 'i.id')
                            ->select(
                                'i.*', 
                                'r.*',
                                DB::raw('DATE_FORMAT(r.released_date, \'%M %d, %Y\') as released_date')
                                )
                            // ->where('r.released_date', '>', 0)
                            ->get();
            return DataTables::of($report)
                    ->addIndexColumn()
                    ->make(true);
        }
        return view('admin.reports', compact('report'));
    }
}
