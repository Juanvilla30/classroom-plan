<?php

namespace App\Http\Controllers;

use App;
use App\Models\Program;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $programs = Program::all();
        $roles = Role::orderBy('id')->get();
        return view('user.user', compact('users', 'roles', 'programs'));
    }

    //Create
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:80',
                'last_name' => 'required|string|max:80',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|max:80',
                'phone' => 'required|string|max:20',
                'idRol' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'check' => false,
                    'errors' => $validator->errors()
                ]);
            }

            User::create([
                'name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'id_role' => $request->input('idRol'),
                'id_program' => $request->input('programId'),
            ]);

            return response()->json([
                'check' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la información.',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    //Read
    public function show(Request $request)
    {
        try {

            $userId = $request->input('userId');

            $User = User::find($userId);

            return response()->json([
                'check' => true,
                'userInfo' => $User,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la información.',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    //Delete
    public function destroy(Request $request)
    {
        try {

            $userId = $request->input('userId');

            User::where('id', $userId)->delete();

            return response()->json([
                'check' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la información.',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    //Update
    public function update(Request $request)
    {
        try {
            $userId = $request->input('userId');
            $Users = User::findOrFail((int) $userId);

            $dataToUpdate = [];

            if ($request->has('updateEmail')) {
                $email = $request->input('updateEmail');

                // Verificar si el correo ya está en uso por otro usuario
                if (User::where('email', $email)->where('id', '!=', $userId)->exists()) {
                    return response()->json([
                        'check' => false,
                        'message' => 'El correo ingresado ya está en uso. Por favor, elija otro.',
                    ]);
                }

                $dataToUpdate['email'] = $email;
            }

            if ($request->has('updateName')) {
                $dataToUpdate['name'] = $request->input('updateName');
            }

            if ($request->has('updateLastName')) {
                $dataToUpdate['last_name'] = $request->input('updateLastName');
            }

            if ($request->has('updatePhone')) {
                $dataToUpdate['phone'] = $request->input('updatePhone');
            }

            if ($request->has('updateRole')) {
                $dataToUpdate['id_role'] = $request->input('updateRole');
            }

            if ($request->has('updateProgram')) {
                $dataToUpdate['id_program'] = $request->input('updateProgram');
            }

            if ($request->filled('updatePassword')) {
                $dataToUpdate['password'] = bcrypt($request->input('updatePassword'));
            }

            if (!empty($dataToUpdate)) {
                $Users->update($dataToUpdate);
            }

            return response()->json([
                'check' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la información.',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
