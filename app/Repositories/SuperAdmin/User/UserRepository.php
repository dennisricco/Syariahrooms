<?php

namespace App\Repositories\SuperAdmin\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Helper\Response;
use App\Models\Role;
use App\Models\User;


class UserRepository
{

    private $response;
    private $user;
    private $role;

    public function __construct(
        Response $response,
        User $user,
        Role $role
    ) {
        $this->response = $response;
        $this->user = $user;
        $this->role = $role;
    }

    public function role()
    {
        return $this->role->get();
    }

    public function index($request)
    {
        $data = [];
        if ($request["role"] != '') {
            $data = $this->user->where('email', 'like', '%' . $request['search'] . '%')->where('name', 'like', '%' . $request['search'] . '%')->whereHas("roles", function ($q) use ($request) {
                $q->where("name", $request['role']);
            })->with('roles')->paginate($request['limit']);
        } else {
            $data = $this->user->where('email', 'like', '%' . $request['search'] . '%')->where('name', 'like', '%' . $request['search'] . '%')->with('roles')->paginate($request['limit']);
        }
        if (count($data) == 0) {
            return $this->response->empty();
        }
        return $this->response->index($data);
    }

    public function show($id)
    {
        $data = $this->user->with('roles')->find($id);
        if (empty($data)) {
            return $this->response->notFound();
        }
        return $this->response->show($data);
    }

    public function store(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address']
        ]);
        $role = $this->role->where('name', $data['role'])->first();

        if ($role) {
            $user->syncRoles([$role->name]);
        }

        return $user;
    }

    public function update(array $data, $id)
    {
        $transaction = User::findOrFail($id);
        $transaction->update($data);
        return $transaction;
    }

    public function destroy($id)
    {
        $check = $this->user->find($id);
        if (empty($check)) {
            return $this->response->notFound();
        }
        $data = $this->user->find($id)->delete();
        if (!$data) {
            return $this->response->destroyError();
        } else {
            return $this->response->destroy($data);
        }
    }
}
