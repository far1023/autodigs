<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::get();

            return DataTables::of($permissions)
                ->addColumn('actions', function ($permissions) {

                    $actions = "<div class='text-right'>";

                    if (Auth::user()->can('edit-permission')) {
                        $url = route('permission.edit', $permissions['id']);

                        $actions .= "<a href='javascript:void(0)' class='btn btn-sm btn-secondary mb-1 mr-1 edit' title='Edit data' data-url='" . $url . "' data-toggle='modal' data-target='#modalFormPermission'>Edit</a>";
                    }
                    if (Auth::user()->can('delete-permission')) {
                        $actions .= " <a href='javascript:void(0)' data-id='" . $permissions['id'] . "' class='btn btn-sm btn-danger mb-1 delete' title='Hapus data'><i class=' las la-times'></i></a>";
                    }

                    return $actions .= "</div>";
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('back.permission');
    }

    public function add()
    {
        return view('components.forms.permission.permission-add');
    }

    public function edit(Permission $permission)
    {
        $data['permission'] = $permission;
        return view('components.forms.permission.permission-edit', $data);
    }

    /**
     * Store the specified resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        try {
            Permission::create($request->all());

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data permission ditambahkan"
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
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        try {
            $permission->update($request->all());

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data permission diperbaharui"
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
    public function delete(Permission $permission)
    {
        try {
            $permission->delete();

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data permission dihapus"
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
