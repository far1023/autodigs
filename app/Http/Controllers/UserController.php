<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles');

            return DataTables::of($users->get())
                ->addColumn('role', function ($s) {
                    $has_roles = [];

                    foreach ($s->roles as $val) {
                        $has_roles[] = $val->name;
                    }
                    return implode(', ', $has_roles);
                })
                ->addColumn('actions', function ($users) {

                    $actions = "<div class='text-right'>";

                    if (Auth::user()->can('edit user')) {
                        $actions .= "<a href='javascript:void(0)' class='btn btn-sm btn-secondary mb-1 mr-1 edit' title='Edit data' onclick='render(\"edit\", " . $users['id'] . ")' data-toggle='modal' data-target='#modalFormUser'>Edit</a>";
                    }
                    if (Auth::user()->can('delete user') && Auth::user()->id != $users['id']) {
                        $actions .= " <a href='javascript:void(0)' data-id='" . $users['id'] . "' class='btn btn-sm btn-danger mb-1 delete' title='Hapus data'><i class=' las la-times'></i></a>";
                    }

                    return $actions .= "</div>";
                })
                ->rawColumns(['role', 'actions'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('back.user');
    }

    public function add()
    {
        return view('components.forms.user-add');
    }

    public function edit(User $user)
    {
        $data['user'] = $user;
        return view('components.forms.user-edit', $data);
    }

    /**
     * Store the specified resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            User::create($request->all());

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data pengguna ditambahkan"
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
    public function update(User $user, UpdateUserRequest $request)
    {
        try {
            $user->update($request->all());

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data pengguna diperbaharui"
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
    public function delete(User $user)
    {
        try {
            $user->delete();

            return response()->json(
                [
                    "code" => 200,
                    "message" => "Data pengguna dihapus"
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
