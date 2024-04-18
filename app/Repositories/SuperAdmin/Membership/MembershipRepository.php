<?php

namespace App\Repositories\SuperAdmin\Membership;

use Illuminate\Support\Facades\Validator;
use App\Helper\Response;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipRepository
{
    private $membership;
    private $response;

    public function __construct(Membership $membership, Response $response)
    {
        $this->response = $response;
        $this->membership = $membership;
    }
    public function all()
    {
        return Membership::all();
    }

    public function searchByName($name, $perPage)
    {
        return Membership::where('name', 'like', "%$name%")->paginate($perPage);
    }

    public function findOrFail($id)
    {
        return Membership::findOrFail($id);
    }

    public function create(array $data)
    {
        return Membership::create($data);
    }

    public function update(array $data, $id)
    {
        $membership = Membership::findOrFail($id);
        $membership->update($data);
        return $membership;
    }

    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->delete();
        return $membership;
    }
}