<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class userController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/api/v1/auth/usuario');
        $users = $response->json();

        $usersConAcceso = array_filter($users, fn($user) => isset($user['accesoTotal']) && $user['accesoTotal'] == true);
        $usersSinAcceso = array_filter($users, fn($user) => !isset($user['accesoTotal']) || $user['accesoTotal'] == false);

        return view('users.index', compact('usersConAcceso', 'usersSinAcceso'));
    }
    public function create()
{
    return view('users.create');
}

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:6',
        'accesoTotal' => 'required|boolean',
    ]);

    $response = Http::post('http://localhost:3000/api/v1/auth/usuario', [
        'nombre' => $request->nombre,
        'email' => $request->email,
        'password' => $request->password,
        'accesoTotal' => $request->accesoTotal,
    ]);

    return $response->successful()
        ? redirect()->route('users.index')->with('success', 'Usuario creado correctamente')
        : back()->withErrors('Error al crear el usuario')->withInput();
}

public function edit($id)
{
    $response = Http::get("http://localhost:3000/api/v1/auth/usuario/{$id}");

    if (!$response->successful()) {
        return redirect()->route('users.index')->withErrors('Usuario no encontrado');
    }

    $user = $response->json();

    return view('users.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:6',
        'accesoTotal' => 'required|boolean',
    ]);

    $data = [
        'nombre' => $request->nombre,
        'email' => $request->email,
        'accesoTotal' => $request->accesoTotal,
    ];

    if (!empty($request->password)) {
        $data['password'] = $request->password;
    }

    $response = Http::put("http://localhost:3000/api/v1/auth/usuario/{$id}", $data);

    return $response->successful()
        ? redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente')
        : back()->withErrors('Error al actualizar el usuario')->withInput();
}

public function destroy($id)
{
    $response = Http::delete("http://localhost:3000/api/v1/auth/usuario/{$id}");

    if ($response->successful()) {
        return redirect()->route('users.index')->with('success', 'Usuario borrado correctamente');
    } else {
        return redirect()->route('users.index')->withErrors('Error al borrar el usuario');
    }
}

}
