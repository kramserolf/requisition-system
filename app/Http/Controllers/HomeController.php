<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Requisition;
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
}
