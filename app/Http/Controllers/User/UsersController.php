<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Domains\User\Actions\UserAction;
use App\Domains\User\DTO\UserDTO\CreateUserData;
use App\Domains\User\DTO\UserDTO\UpdateUserData;
use App\Domains\User\Gateways\UserGateway;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
//        $filters = json_decode($request->get('filters'), true);
//
//        $query = User::query();
//
//        if (!empty($request->get('filters'))) {
//            if (!empty($filters['role'])) {
//                $query->where('role', $filters['role']);
//            }
//            if (!empty($filters['start_created_date'])) {
//                $query->where('created_at', '>=', $filters['start_created_date']);
//            }
//            if (!empty($filters['end_created_date'])) {
//                $query->where('created_at', '<=', $filters['end_created_date']);
//            }
//        }
//
//        if (!empty($request->get('keywords'))) {
//            $query->where('name', 'like', '%' . $request->get('keywords') . '%')
//                ->orWhere('email', 'like', '%' . $request->get('keywords') . '%');
//        }
//
//        $users = $query->get();
        $user = Auth::user();
        $gateway = new UserGateway();

        $keywords = $request->get('keywords');
        if ($keywords) {
            $gateway->setSearch($keywords, ['first_name', 'last_name', 'email']);
        }

        $filters = json_decode($request->get('filters'), true);
        if ($filters) {
            $gateway->setFilters($filters);
        }

        $gateway->paginate(20);

        return $gateway->all($user->id);
    }

    /**
     * @param CreateUserRequest $request
     * @return User
     */
    public function store(CreateUserRequest $request)
    {
        $data = new CreateUserData([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => (int)$request->role
        ]);

        return (new UserAction)->create($data);
    }

    public function show(Request $request, $userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user, 404, 'user not found');
        return $user;
    }

    public function edit(Request $request, $userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user, 404, 'user not found');

        return $user;
    }

    public function update(int $id, UpdateUserRequest $request)
    {
        $data = new UpdateUserData([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => $request->get('password') ? Hash::make($request->get('password')) : null,
            'email' => $request->email,
            'role' => (int)$request->role,
            'id' => $id
        ]);

        return (new UserAction)->update($data);
    }

    public function delete($userId)
    {
        $user = User::find($userId);
        abort_unless((bool)$user, 404, 'user not found');

        $user->delete();
        return $user;
    }

    public function getChartLineCustomersData()
    {
        $data = [];

        $data['labels'] = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];

        $data['datasets'][0] = [];
        $data['datasets'][0]['label'] = 'Customers';
        $data['datasets'][0]['borderColor'] = '#00D8FF';
        $data['datasets'][0]['backgroundColor'] = 'blue';

        $date = Carbon::now();
        $startJanuary = $date->copy()->startOfYear();
        $startFebruary = $startJanuary->copy()->addMonth();
        $startMarch = $startFebruary->copy()->addMonth();
        $startApril = $startMarch->copy()->addMonth();
        $startMay = $startApril->copy()->addMonth();
        $startJune = $startMay->copy()->addMonth();
        $startJuly = $startJune->copy()->addMonth();
        $startAugust = $startJuly->copy()->addMonth();
        $startSeptember = $startAugust->copy()->addMonth();
        $startOctober = $startSeptember->copy()->addMonth();
        $startNovember = $startOctober->copy()->addMonth();
        $startDecember = $startNovember->copy()->addMonth();

        $customers = User::where([
            'role' => User::USER_ROLE_CUSTOMER,
            ['created_at', '>=', $startJanuary]
        ])->get();

        $data['datasets'][0]['data'] = [
            $customers
                ->where('created_at', '>=', $startJanuary)
                ->where('created_at', '<', $startFebruary)
                ->count(),
            $customers
                ->where('created_at', '>=', $startFebruary)
                ->where('created_at', '<', $startMarch)
                ->count(),
            $customers
                ->where('created_at', '>=', $startMarch)
                ->where('created_at', '<', $startApril)
                ->count(),
            $customers
                ->where('created_at', '>=', $startApril)
                ->where('created_at', '<', $startMay)
                ->count(),
            $customers
                ->where('created_at', '>=', $startMay)
                ->where('created_at', '<', $startJune)
                ->count(),
            $customers
                ->where('created_at', '>=', $startJune)
                ->where('created_at', '<', $startJuly)
                ->count(),
            $customers
                ->where('created_at', '>=', $startJuly)
                ->where('created_at', '<', $startAugust)
                ->count(),
            $customers
                ->where('created_at', '>=', $startAugust)
                ->where('created_at', '<', $startSeptember)
                ->count(),
            $customers
                ->where('created_at', '>=', $startSeptember)
                ->where('created_at', '<', $startOctober)
                ->count(),
            $customers
                ->where('created_at', '>=', $startOctober)
                ->where('created_at', '<', $startNovember)
                ->count(),
            $customers
                ->where('created_at', '>=', $startNovember)
                ->where('created_at', '<', $startDecember)
                ->count(),
            $customers
                ->where('created_at', '>=', $startDecember)
                ->where('created_at', '<', $startJanuary)
                ->count(),
        ];

        return $data;
    }
}
