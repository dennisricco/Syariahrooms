<?php

namespace App\Http\Controllers\SuperAdmin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SuperAdmin\User\UserRepository;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->middleware('permission:user-index|user-store|user-update|user-destroy', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:user-store', ['only' => ['store']]);
        $this->middleware('permission:user-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-destroy', ['only' => ['destroy']]);
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $role = $this->userRepository->role();
        return view('master.dashboard.user.index', compact('role'));
    }

    public function data(Request $request)
    {
        $data = $this->userRepository->index($request);
        return $data;
    }

    public function show($id)
    {
        $data = $this->userRepository->show($id);
        return $data;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'role' => 'required|string',
        ]);
        
        if ($request->filled('id')) {
            $this->update($request);
            return response()->json(['message' => 'User updated successfully']);
        } else {
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            $user = $this->userRepository->store($request->all());

            if ($user) {
                return response()->json(['message' => 'User added successfully', 'user' => $user]);
            } else {
                return response()->json(['message' => 'Failed to add user'], 500);
            }
        }
    }

    public function update(Request $request)
    {
        $this->userRepository->update($request->all(), $request->id);
    }

    public function destroy($id)
    {
        $data = $this->userRepository->destroy($id);
        return $data;
    }
}
