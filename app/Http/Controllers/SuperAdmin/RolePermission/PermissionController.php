<?php

namespace App\Http\Controllers\SuperAdmin\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SuperAdmin\RolePermission\PermissionRepository;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $permissionRepository;

    public function __construct(
        PermissionRepository $permissionRepository
    ) {
        $this->middleware('permission:role-index|role-store|role-update|role-destroy', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:role-store', ['only' => ['store']]);
        $this->middleware('permission:role-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-destroy', ['only' => ['destroy']]);
        $this->permissionRepository = $permissionRepository;
    }

    public function index($id)
    {
        $permission = $this->permissionRepository->getAllPermissions();
        $data = $this->permissionRepository->index($id);
        $kata = $this->extractFirstWord();
        return view('master.dashboard.role-permission.permission', compact('data', 'kata', 'permission'));
    }

    public function store(Request $request)
    {
        $data = $this->permissionRepository->store($request);
        return redirect()->route('dashboard.role.index')->with('success', 'Permissions successfully synchronized');
    }

    public function addPermission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $permission = $this->permissionRepository->createPermission($request->all());

        return response()->json(['message' => 'Permission created successfully', 'permission' => $permission]);
    }

    public function show($id)
    {
        $data = $this->permissionRepository->show($id);
        return $data;
    }

    public function extractFirstWord()
    {
        $permission = $this->permissionRepository->pluckPermissionNames();

        $results = [];

        foreach ($permission as $name) {
            $parts = explode('-', $name);

            $result = $parts[0];

            if (!in_array($result, $results)) {
                $results[] = $result;
            }
        }
        return $results;
    }
}
