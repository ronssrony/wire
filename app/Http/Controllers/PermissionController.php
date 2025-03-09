<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function store()
    {
        $exists = Permission::where('user_id', auth()->id())->first(); // Fetch the actual record

        if (!$exists) {
            Permission::create([
                'user_id' => auth()->id(),
                'status' => 'pending'
            ]);
        }
        else if ($exists->status === 'rejected') {
            $exists->status = 'pending';
            $exists->save();
        }
    }

    public function index(){
        $notifications = Permission::with('user')->latest() ->get();
        return view('wire.admin-notification' , compact('notifications'));
    }

    public function accept($id){
        $permission = Permission::find($id) ;
        $permission->status = 'approved';
        $user = User::find($permission->user_id);
        $user->role = 'author';
        $user->save();
        $permission->save();
        return redirect()->back();
    }
    public function reject($id){
        $permission = Permission::find($id) ;
        $permission->status = 'rejected';
        $permission->save();
        return redirect()->back();
    }
}
