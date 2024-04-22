<?php

namespace App\Repositories\SuperAdmin\RolePermission;

use App\Helper\Response;
use App\Models\Permission;
use App\Models\Role;

class PermissionRepository
{
    protected $response;
    private $role;
    private $permission;

    public function __construct(
        Response $response,
        Role $role,
        Permission $permission
    ) {
        $this->role = $role;
        $this->permission = $permission;
        $this->response = $response;
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function index($id)
    {
        $role = $this->role->where('id', $id)->with(['permissions'])->firstOrFail();
        $permissions = $this->getAllPermissions();
        $data = [
            'role' => $role,
            'permissions' => $permissions
        ];
        return $data;
    }

    public function store($request)
    {
        $data = $this->role::find($request['id']);
        $data->syncPermissions($request['permission']);
        return $data;
    }

    public function createPermission(array $data)
    {
        return Permission::create($data);
    }

    public function show($id)
    {
        $data = $this->permission->find($id);
        if (empty($data)) {
            return $this->response->notFound();
        }
        return $this->response->show($data);
    }

    public function pluckPermissionNames()
    {
        return Permission::pluck('name')->toArray();
    }
}
