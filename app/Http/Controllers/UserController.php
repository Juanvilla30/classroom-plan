<?php

namespace App\Http\Controllers;

use App;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser un correo válido.',
            'max' => [
                'string' => 'El campo :attribute no puede tener más de :max caracteres.',
            ],
            'unique' => 'El :attribute ya está en uso.',
            'integer' => 'El campo :attribute debe ser un número entero.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|max:255',
            'phone' => 'required|string|max:11',
            'id_role' => 'required|integer',
        ], $messages);

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
        // Mensajes de validación personalizados
        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser un correo válido.',
            'max.string' => 'El campo :attribute no puede tener más de :max caracteres.',
            'unique' => 'El :attribute ya está en uso.',
            'integer' => 'El campo :attribute debe ser un número entero.',
        ];

        try {
            // Buscar usuario (maneja error si no existe)
            $Users = User::findOrFail($id);

            // Validar la solicitud con mensajes personalizados
            $validator = Validator::make($request->all(), [
                'name' => 'max:255',
                'last_name' => 'max:255',
                'email' => 'email|unique:users,email,' . $id,
                'password' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:11',
                'id_role' => 'integer'
            ], $messages);

            // Si la validación falla, devolver errores detallados
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error en la validación',
                    'errors' => $validator->errors(),
                    'status' => 400
                ], 400);
            }

            // Actualizar solo los campos enviados en la solicitud
            $Users->fill($request->only(['name', 'last_name', 'email', 'phone', 'id_role']));

            if ($request->filled('password')) {
                $Users->password = bcrypt($request->password);
            }

            $Users->save();

            return response()->json([
                'message' => 'Usuario actualizado',
                'User' => $Users,
                'status' => 200
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error inesperado',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
