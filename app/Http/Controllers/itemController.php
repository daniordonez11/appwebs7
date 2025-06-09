<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/api/v1/auth/item');
        $items = $response->json();

        return view('item.index', compact('items'));
    }

    public function create()
{
    return view('item.create');
}

public function store(Request $request)
{
    // Validar datos básicos
    $request->validate([
        'descripcion' => 'required|string|max:255',
        'cantidad' => 'required|integer',
        'observacion' => 'nullable|string|max:255',
    ]);

    // Enviar POST a la API
    $response = Http::post('http://localhost:3000/api/v1/auth/item', [
        'descripcion' => $request->descripcion,
        'cantidad' => $request->cantidad,
        'observacion' => $request->observacion,
    ]);

    if ($response->successful()) {
        return redirect()->route('item.index')->with('success', 'Item creado correctamente');
    } else {
        return back()->withErrors('Error al crear el item')->withInput();
    }
}

public function edit($id)
{
    $response = Http::get("http://localhost:3000/api/v1/auth/item/{$id}");

    if (!$response->successful()) {
        return redirect()->route('item.index')->withErrors('Item no encontrado');
    }

    $fullItem = $response->json();

    // Crear un array solo con los campos necesarios
    $item = [
        'id' => $fullItem['id'],
        'descripcion' => $fullItem['descripcion'],
        'cantidad' => $fullItem['cantidad'],
        'observacion' => $fullItem['observacion'],
    ];

    return view('item.edit', compact('item'));
}

public function update(Request $request, $id)
{
    // Validar datos
    $request->validate([
        'descripcion' => 'required|string|max:255',
        'cantidad' => 'required|integer',
        'observacion' => 'nullable|string|max:255',
    ]);

    // Enviar PUT para actualizar el item en la API
    $response = Http::put("http://localhost:3000/api/v1/auth/item/{$id}", [
        'descripcion' => $request->descripcion,
        'cantidad' => $request->cantidad,
        'observacion' => $request->observacion,
    ]);

    if ($response->successful()) {
        return redirect()->route('item.index')->with('success', 'Item actualizado correctamente');
    } else {
        return back()->withErrors('Error al actualizar el item')->withInput();
    }
}

}
