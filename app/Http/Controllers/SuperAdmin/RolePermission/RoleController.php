<?php

namespace App\Http\Controllers\SuperAdmin\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SuperAdmin\RolePermission\RoleRepository;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(
        RoleRepository $roleRepository
    ){
        $this->middleware('permission:role-index|role-store|role-update|role-destroy', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:role-store', ['only' => ['store']]);
        $this->middleware('permission:role-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-destroy', ['only' => ['destroy']]);
        $this->roleRepository = $roleRepository;
    }

    public function index(){
        return view('master.dashboard.role-permission.role');
    }

    public function data(Request $request){
        $data = $this->roleRepository->index($request);
        return $data;
    }

    public function show($id){
        $data = $this->roleRepository->show($id);
        return $data;   
    }

    public function store(Request $request){
        $data = $this->roleRepository->store($request);
        return $data;   
    }

    public function destroy($id){
        $data = $this->roleRepository->destroy($id);
        return $data;
    }
}
