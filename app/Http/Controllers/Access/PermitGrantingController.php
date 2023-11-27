<?php

namespace App\Http\Controllers\Access;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\GrantPermissionsRequest;
use Spatie\Permission\Models\Permission;

class PermitGrantingController extends Controller
{
    public function edit(int $id)
    {
        $data['role'] = Role::with('permissions')->findOrFail($id);
        $data['set_permissions'] = $data['role']->permissions()->pluck('id')->toArray();

        $data['permissions'] = Permission::get();
        $data['groups'] = Permission::select('group')->distinct()->pluck('group')->toArray();

        return view('components.forms.role.permit-granting', $data);
    }

    public function update(Role $role, GrantPermissionsRequest $request)
    {
        try {
            $role->syncPermissions($request->permission_name);

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Role's access updated"
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
