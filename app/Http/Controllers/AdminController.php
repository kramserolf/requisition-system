<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalRequisition = DB::table('requisitions')->count();

        $totalReleased = DB::table('requisitions')
                                    ->select('released_date')
                                    ->where('requisitions.released_date', '>', 1)
                                    ->count();
        $totalApprovals = DB::table('requisitions')
                                ->select('approval_status')
                                ->where('approval_status', 'approved')
                                ->count();
        $totalRejected = DB::table('requisitions')
                                ->select('status')
                                ->where('status', 'rejected')
                                ->count();

        return view('admin.home', [
            'totalRequisition' => $totalRequisition,
            'totalReleased' => $totalReleased,
            'totalApprovals' => $totalApprovals,
            'totalRejected' => $totalRejected
        ]);
    }

    public function vpIndex()
    {
        $totalRequisition = DB::table('requisitions')->count();

        $totalReleased = DB::table('requisitions')
                                    ->select('released_date')
                                    ->where('requisitions.released_date', '>', 1)
                                    ->count();
        $totalApprovals = DB::table('requisitions')
                                ->select('approval_status')
                                ->where('approval_status', 'approved')
                                ->count();
        $totalRejected = DB::table('requisitions')
                                ->select('status')
                                ->where('status', 'rejected')
                                ->count();

        return view('admin.home2', [
            'totalRequisition' => $totalRequisition,
            'totalReleased' => $totalReleased,
            'totalApprovals' => $totalApprovals,
            'totalRejected' => $totalRejected
        ]);
    }

    public function presidentIndex()
    {
        $totalRequisition = DB::table('requisitions')->count();

        $totalReleased = DB::table('requisitions')
                                    ->select('released_date')
                                    ->where('requisitions.released_date', '>', 1)
                                    ->count();
        $totalApprovals = DB::table('requisitions')
                                ->select('approval_status')
                                ->where('approval_status', 'approved')
                                ->count();
        $totalRejected = DB::table('requisitions')
                                ->select('status')
                                ->where('status', 'rejected')
                                ->count();

        return view('admin.home3', [
            'totalRequisition' => $totalRequisition,
            'totalReleased' => $totalReleased,
            'totalApprovals' => $totalApprovals,
            'totalRejected' => $totalRejected
        ]);
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'current_password' => 'nullable|required_with:new_password',
        ]);

        // get image name
        $file = $request->file('image');
        $imageName = $file->getClientOriginalName();
        // move the image to folder
        $request->image->move(public_path('images/'), $imageName);

        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->image = $imageName;

        $user->save();

        return back()->withSuccess('Profile updated successfully.');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password'
        ]);


        $user = User::findOrFail(Auth::user()->id);

        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withInput();
            }
        }

        $user->save();

        return back()->withSuccess('Profile updated successfully.');
    }

}
