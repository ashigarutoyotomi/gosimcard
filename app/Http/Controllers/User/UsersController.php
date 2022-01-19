<?php

namespace App\Http\Controllers\User;

use App\Domains\User\Actions\UserAction;
use App\Domains\User\DTO\UserDTO\CreateUserData;
use App\Domains\User\DTO\UserDTO\UpdateUserData;
use App\Domains\User\Gateways\UserGateway;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Get all users
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        // $gateway = new UserGateway;

        //filters is array
        $filters = $request->filters;
        $users = [];
        $isArray = is_array($filters);
        abort_unless($isArray, 406, 'parameter \'filters\' must an array');
        if ($filters['role'] != null && $filters['start_created_date'] == null && $filters['end_created_date'] == null) {
            $users = User::where('role', $filters['role'])->get();
            return $users;
        } elseif ($filters['role'] == null && $filters['start_created_date'] != null) {
            $users = User::where('created_at', '>=', $filters['start_created_date'])->get();
            return $users;
        } else if ($filters['role'] == null & $filters['start_created_date'] != null && $filters['end_created_date'] != null) {
            $users = User::where('created_at', '<=', $filters['end_created_date'])
                ->where('created_at', '>=', $filters['start_created_date'])
                ->get();
            return $users;
        } else {
            $users = User::where('created_at', '<=', $filters['end_created_date'])
                ->where('created_at', '>=', $filters['start_created_date'])
                ->where('role', $filters['role'])
                ->get();
            return $users;
        }
        // return $gateway->all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'required|string|max:50',
            'role' => 'required|int'
        ]);

        $data = new CreateUserData([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        $user = (new UserAction)->create($data);

        return $user;
    }

    public function show(Request $request, $userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user, 404, 'user not found');
        return response()->json([$user]);
    }

    public function edit(Request $request, $userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user, 404, 'user not found');
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
            'name' => $request->name,
            'password' => $request->password,
            'email' => $request->email,
            'role' => (int)$request->role,
            'id' => (int)$userId
        ]);

        $user = (new UserAction)->update($data);
        return $user;
    }

    public function delete($userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user, 404, 'user not found');
        $user->delete();
        return $user;
    }
    public function search(Request $request)
    {
        $validated = $request->validate([
            'column' => 'required|string',
            'keywords' => 'required|string'
        ]);
        $keywords = $request->keywords;
        if ($request->column == 'email' && $request->column != 'name') {
            $users = User::where('email', 'like', "%" . $request->keywords . "%")->get();
            return $users;
        } elseif ($request->column == 'name' && $request->column != 'email') {
            $users = User::where('name', 'like', "%" . $request->keywords . "%")->get();
            return $users;
        }
    }
}
