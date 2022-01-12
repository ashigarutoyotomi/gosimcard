<?php

namespace App\Http\Controllers;

use App\Domains\User\Actions\UserAction;
use App\Domains\User\DTO\UserDTO\UpdateUserData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Domains\User\DTO\UserDTO\CreateUserData;
class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return response()->json([$users]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'required|string|max:50',
            'role'=>'required|int'
        ]);
        $data = new CreateUserData(     ['name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role]);
        $user = (new UserAction)->create($data);
        return $user;
    }
    public function show(Request $request, $userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user,404,'user not found');
        return response()->json([$user]);
    }
    public function edit(Request $request, $userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user,404,'user not found');
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ]);
    }
    public function update(Request $request, $userId)
    {
        $data = new UpdateUserData([
            'name'=>$request->name,
            'password'=>$request->password,
            'email'=>$request->email,
            'role'=>(int)$request->role,
           'id'=>(int)$userId
        ]);

       $user = (new UserAction)->update($data);
        return $user;
    }
    public function delete($userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user,404,'user not found');
        $user->delete();
        return $user;
    }
}
