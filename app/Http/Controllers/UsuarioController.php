<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = \App\Models\User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }
    
    public function store(Request $request)
    {

        $request->validate([
            'name'     => 'required|min:3|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ], [
    'name.required'      => 'El nombre es obligatorio.',
    'name.min'           => 'El nombre debe tener al menos 3 caracteres.',
    'email.required'     => 'El correo es obligatorio.',
    'email.email'        => 'Escribe un correo válido.',
    'email.unique'       => 'Ese correo ya está registrado.',
    'password.required'  => 'La contraseña es obligatoria.',
    'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
    'password.confirmed' => 'Las contraseñas no coinciden.',
]);

        
        \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);


        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Usuario creado correctamente');
    }
}
