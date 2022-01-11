<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'required|string|max:50',
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->to('/');
    }
    public function show(Request $request, $userId)
    {
        $user = User::find($userId);
        return response()->json(['user' => $user]);
    }
    public function edit(Request $request, $userId)
    {
        $user = User::find($userId);
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);
    }
    public function update(Request $request, $userId)
    {
        $user = User::find($userId);
        $user->name = $request->name ? $request->name : $user->name;
        $user->email = $request->email ? $request->email : $user->email;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
    }
    function delete (Request $request,$userId){
        try {
            $user = User::find($showId);
            $user->delete();
        }catch($e){
            return response()->json(['msg'=>$e]);
        }
        return response()->json(['msg'=>'succesfully deleted user by'. $user->id]);
    }
}
