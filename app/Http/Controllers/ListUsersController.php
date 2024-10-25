<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ListUsersController extends Controller
{
    // Método para manejar solicitudes GET
    public function index()
    {
        return view('user.ListUsers');
    }
}
