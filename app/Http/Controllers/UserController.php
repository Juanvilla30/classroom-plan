<?php

namespace App\Http\Controllers;

use App;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::orderBy('id')->get();
        return view('user.user', compact('users', 'roles'));
    }

    //Create
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|max:255',
            'phone' => 'required|string|max:10',
            'id_role' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'id_role' => $request->input('id_role'),
        ]);
        return response()->json(['success' => true, 'message' => 'Usuario creado'], 200);
    }

    //Read
    public function show($id)
    {
        $User = User::find($id);

        if (!$User) {
            $data = [
                'mesagge' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'user' => $User,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    //Delete
    public function destroy($id)
    {
        $Users = User::find($id);
        if (!$Users) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $Users->delete();

        $data = [
            'message' => 'Usuario eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    //Update
    public function update(Request $request, $id)
    {
        $Users = User::findOrFail($id);
        if (!$Users) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'last_name' => 'max:255',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'string|max:255',
            'phone' => 'string|max:10',
            'id_role' => 'integer'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error al actualizar datos',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $Users->name = $request->name;
        }
        if ($request->has('last_name')) {
            $Users->last_name = $request->last_name;
        }
        if ($request->has('email')) {
            $Users->email = $request->email;
        }
        if ($request->has('password')) {
            $Users->password = bcrypt($request->password);
        }
        if ($request->has('phone')) {
            $Users->phone = $request->phone;
        }
        if ($request->has('id_role')) {
            $Users->id_role = $request->id_role;
        }

        $Users->save();
        $data = [
            'message' => 'Usuario actualizado',
            'User' => $Users,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

}