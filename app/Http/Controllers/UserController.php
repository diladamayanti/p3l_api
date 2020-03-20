<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;


class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::with(['orders'])->get());
    }

    public function login(Request $request)
    {
        $status = 401;
        $response = ['error' => 'Unauthorised'];

        if (Auth::attempt($request->only(['email', 'password']))) {
            $status = 200;
            $response = [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('bigStore')->accessToken,
            ];
        }

        return response()->json($response, $status);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->is_admin = 0;

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('bigStore')->accessToken,
        ]);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function showOrders(User $user)
    {
        return response()->json($user->orders()->with(['product'])->get());
    }
    // public function index()
    // {
    //     $user = User::all();
    //     $response = [
    //         'status' => 'Success',
    //         'data' => $user
    //     ];
    //     return response()->json($response, 200);
    // }

    public function tampilSoftDelete()
    {
        $user = User::onlyTrashed()->get();
        $response = [
            'status' => 'Success',
            'data' => $user
        ];
        return response()->json($response, 200);
    }

    public function cariUser($cari)
    {
        $user = User::where('id', 'like', '%' . $cari . '%')->get();

        if (sizeof($user) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {

            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $user
            ];
        }
        return response()->json($response, $status);
    }

    public function tambah(Request $request)
    {
        $user = new User();
        $user->NIP = $request['NIP'];
        $user->name = $request['name'];
        $user->password = $request['password'];
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();

        try {
            $success = $user->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $user
            ];
        } catch (\Illuminate\Database\QueryException $e) {
            $status = 500;
            $response = [
                'status' => 'Error',
                'data' => [],
                'message' => $e
            ];
        }
        return response()->json($response, $status);
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);

        if ($user == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $user->NIP = $request['NIP'];
            $user->name = $request['name'];
            $user->password = $request['password'];
            $user->updated_at = Carbon::now();

            try {
                $success = $user->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $user
                ];
            } catch (\Illuminate\Database\QueryException $e) {
                $status = 500;
                $response = [
                    'status' => 'Error',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response, $status);
    }

    public function hapus($id)
    {
        $user = User::find($id);

        if ($user == NULL || $user->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $user->deleted_at = Carbon::now();
            $user->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $user
            ];
        }
        return response()->json($response, $status);
    }

    public function restore(Request $request, $id)
    {
        $user = User::find($id);

        if ($user == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $user->updated_at = Carbon::now();
            $user->deleted_at = NULL;

            $user->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $user
            ];
        }
        return response()->json($response, $status);
    }

    public function hapusPermanen($id)
    {
        $user = User::find($id);

        if ($user == NULL || $user->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $user->delete();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $user
            ];
        }
        return response()->json($response, $status);
    }
}
