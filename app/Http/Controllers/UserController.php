<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    protected $logging;

    public function __construct()
    {
        $this->logging = Log::channel('file');
    }

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

                    if (Auth::user()->can('assign-role')) {
                        $url = route('role.show-role', $users['id']);

                        $actions .= "<a href='javascript:void(0)' class='btn btn-xs btn-warning mb-1 mr-1 grant-permissions' title='Granted permissions'  data-url='" . $url . "' data-toggle='modal' data-target='#modalFormPermitGranting'><i class='las la-lg la-key'></i></a>";
                    }
                    if (Auth::user()->can('edit-user')) {
                        $url = route('user.edit', $users['id']);

                        $actions .= "<a href='javascript:void(0)' class='btn btn-xs btn-secondary mb-1 mr-1 edit' title='Edit data' data-url='" . $url . "' data-toggle='modal' data-target='#modalFormUser'>Edit</a>";
                    }
                    if (Auth::user()->can('delete-user') && Auth::user()->id != $users['id']) {
                        $actions .= " <a href='javascript:void(0)' data-id='" . $users['id'] . "' class='btn btn-xs btn-danger mb-1 delete' title='Hapus data'><i class=' las la-times'></i></a>";
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
        return view('components.forms.user.user-add');
    }

    public function edit(User $user)
    {
        $data['user'] = $user;
        return view('components.forms.user.user-edit', $data);
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

            $this->logging->info("User deleted!", ["username" => $user->username, "deleted_by" => Auth::user()->name]);

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
