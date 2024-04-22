<?php

namespace App\Http\Controllers\SuperAdmin\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Repositories\SuperAdmin\Membership\MembershipRepository;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
{
    private $membershipRepository;

    public function __construct(
        MembershipRepository $membershipRepository
    ) {
        $this->middleware('permission:membership-index|membership-store|membership-update|membership-destroy', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:membership-store', ['only' => ['store']]);
        $this->middleware('permission:membership-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:membership-destroy', ['only' => ['destroy']]);
        $this->membershipRepository = $membershipRepository;
    }

    public function index()
    {
        $membership = $this->membershipRepository->all();
        return view('master.dashboard.membership.index', ['membership' => $membership]);
    }

    public function data(Request $request)
    {
        $perPage = 10;
        $search = $request->input('search');
        $memberships = $this->membershipRepository->searchByName($search, $perPage);

        return response()->json($memberships);
    }

    public function show($id)
    {
        $membership = $this->membershipRepository->findOrFail($id);
        return response()->json(['data' => $membership]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'fitur' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        if ($request->filled('id')) {
            $this->update($request);
            return response()->json(['message' => 'Membership updated successfully']);
        } else {
            $membership = $this->membershipRepository->create($request->all());
            $roleName = 'Member-' . $membership->name;

            if (!Role::where('name', $roleName)->exists()) {
                Role::create(['name' => $roleName]);
            }
            return response()->json(['message' => 'Membership added successfully']);
        }
    }

    public function update(Request $request)
    {
        $this->membershipRepository->update($request->all(), $request->id);       
    }

    public function destroy($id)
    {
        try {
            $this->membershipRepository->destroy($id);
            return response()->json(['message' => 'Membership deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
