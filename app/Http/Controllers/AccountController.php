<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\AcceptHeader;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $account = [];
        if($request->ajax()){
            $account = DB::table('accounts as a')
                            ->leftJoin('users as u', 'a.user_id', 'u.id')
                            ->select('a.*','u.name', 'u.username')
                            ->get();
            return DataTables::of($account)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editAccount"><i class="bi-pencil-square"></i> </a> ';
                        $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteAccount"><i class="bi-trash"></i> </a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.accounts', compact('account'));
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
            'role_type' => 'required|string',
            'name' => 'required|string|max:191',
            'username' => 'required|string|max:191',
            'email' => 'required|string|unique:users',
            'position' => 'required|string'
        ]);

        $passwordExplode = explode(' ', $request->name);
        $password = strtolower(implode('', $passwordExplode));

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($password),
            'is_role' => 0
        ]);

        Account::create([
            'user_id' => $user->id,
            'role_type' => $request->role_type,
            'position' => $request->position
        ]);

        return response()->json(['success' => 'Successfulle added']);
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
        $userid = Account::where('id', $request->id)
                        ->select('user_id')
                        ->first();
        User::where('id', $userid->user_id)
                    ->delete();
        Account::where('id', $request->id)
                    ->delete();
    }
}
