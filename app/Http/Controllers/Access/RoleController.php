<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::where('name', '!=', 'super-admin')->get();

            return DataTables::of($roles)
                ->addColumn('permissions', function ($data) {
                    return count($data->permissions) . " permission(s) granted";
                })
                ->addColumn('actions', function ($roles) {

                    $actions = "<div class='text-right'>";

                    if (Auth::user()->can('grant permit')) {
                        $actions .= "<a href='javascript:void(0)' class='btn btn-sm btn-warning mb-1 mr-1 edit' title='Edit data' onclick='renderPermit(\"/" . $roles['id'] . "/grant-permit\")' data-toggle='modal' data-target='#modalFormPermitGranting'><i class='las la-lg la-key'></i></a>";
                    }
                    if (Auth::user()->can('edit role')) {
                        $actions .= "<a href='javascript:void(0)' class='btn btn-sm btn-secondary mb-1 mr-1 edit' title='Edit data' onclick='render(\"edit\", " . $roles['id'] . ")' data-toggle='modal' data-target='#modalFormRole'>Edit</a>";
                    }
                    if (Auth::user()->can('delete role')) {
                        $actions .= " <a href='javascript:void(0)' data-id='" . $roles['id'] . "' class='btn btn-sm btn-danger mb-1 delete' title='Hapus data'><i class=' las la-times'></i></a>";
                    }

                    return $actions .= "</div>";
                })
                ->rawColumns(['permissions', 'actions'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('back.role');
    }

    public function add()
    {
        return view('components.forms.role.role-add');
    }

    public function edit(Role $role)
    {
        $data['role'] = $role;
        return view('components.forms.role.role-edit', $data);
    }

    /**
     * Store the specified resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            Role::create($request->all());

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data role ditambahkan"
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                ["message" => $th->getMessage()],
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Role $role, UpdateRoleRequest $request)
    {
        try {
            $role->update($request->all());

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data role diperbaharui"
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                ["message" => $th->getMessage()],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Role $role)
    {
        try {
            $role->delete();

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data role dihapus"
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                ["message" => $th->getMessage()],
                500
            );
        }
    }
}
