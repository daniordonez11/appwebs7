<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    // Cambia todas las URLs para que usen "order" o "orden" consistentemente
    protected $apiBase = 'http://localhost:3000/api/v1/auth/order';

    public function index()
    {
        $response = Http::get($this->apiBase);

        $orders = $response->successful() ? $response->json() : [];

        return view('order.index', compact('orders'));
    }

    public function create()
    {
        $response = Http::get('http://localhost:3000/api/v1/auth/usuario');
        $usuarios = $response->successful() ? collect($response->json())->where('accesoTotal', true) : collect();

        return view('order.create', compact('usuarios'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nombreCliente' => 'required|string|max:255',
        'telefonoCliente' => 'required|integer',
        'emailCliente' => 'nullable|email|max:255',
        'modeloPc' => 'required|string|max:255',
        'numeroSeriePc' => 'nullable|numeric',
        'estadoInicial' => 'nullable|string|max:255',
        'accesoriosEntregados' => 'nullable|string|max:255',
        'estado' => 'required|string',
        'usuarioId' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Crear la orden
    $response = Http::post($this->apiBase, $request->only([
        'nombreCliente', 'telefonoCliente', 'emailCliente', 'modeloPc',
        'numeroSeriePc', 'estadoInicial', 'accesoriosEntregados', 'estado', 'usuarioId'
    ]));

    if (!$response->successful()) {
        return back()->withErrors('Error al crear la orden')->withInput();
    }

    $orden = $response->json();
    $ordenId = $orden['id'] ?? null;

    // Subir la imagen como archivo usando multipart/form-data
    if ($ordenId && $request->hasFile('image')) {
        $imagen = $request->file('image');

        Http::attach(
            'image', 
            file_get_contents($imagen->getRealPath()),
            $imagen->getClientOriginalName()
        )->post('http://localhost:3000/api/v1/auth/images/upload', [
            'ordenId' => $ordenId,
        ]);
    }

    return redirect()->route('order.index')->with('success', 'Orden creada correctamente');
}


    public function edit($id)
{
    $responseOrden = Http::get($this->apiBase . '/' . $id);
    if (!$responseOrden->successful()) {
        return redirect()->route('order.index')->withErrors('Orden no encontrada');
    }
    $orden = $responseOrden->json();

    // Obtener imágenes desde la API de imágenes asociadas a esta orden
    $responseImagenes = Http::get("http://localhost:3000/api/v1/auth/images/orden/{$id}");
    $imagenes = $responseImagenes->successful() ? collect($responseImagenes->json()) : collect();

    $responseUsuarios = Http::get('http://localhost:3000/api/v1/auth/usuario');
    $usuarios = $responseUsuarios->successful() ? collect($responseUsuarios->json())->where('accesoTotal', true) : collect();

    return view('order.edit', compact('orden', 'usuarios', 'imagenes'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
        'nombreCliente' => 'required|string|max:255',
        'telefonoCliente' => 'required|integer',
        'emailCliente' => 'nullable|email|max:255',
        'modeloPc' => 'required|string|max:255',
        'numeroSeriePc' => 'nullable|numeric',
        'estadoInicial' => 'nullable|string|max:255',
        'accesoriosEntregados' => 'nullable|string|max:255',
        'estado' => 'required|string',
        'usuarioId' => 'required|integer',
        ]);

        $response = Http::put($this->apiBase . '/' . $id, $request->only([
            'nombreCliente', 'telefonoCliente', 'emailCliente', 'modeloPc', 
        'numeroSeriePc', 'estadoInicial', 'accesoriosEntregados', 'estado', 'usuarioId'
        ]));

        return $response->successful()
            ? redirect()->route('order.index')->with('success', 'Orden actualizada correctamente')
            : back()->withErrors('Error al actualizar la orden')->withInput();
    }

    public function images($orderId)
{
    $response = Http::get("http://localhost:3000/api/v1/auth/images/{$orderId}");

    if (!$response->successful()) {
        return response()->json(['error' => 'No se encontraron imágenes'], 404);
    }

    return response()->json($response->json());
}

public function uploadImage(Request $request, $orderId)
    {
        $request->validate([
            'imagen' => 'required|image|max:2048', // máximo 2MB
        ]);

        $file = $request->file('imagen');
        $filename = $file->getClientOriginalName();
        $fileContents = base64_encode(file_get_contents($file->getRealPath()));

        // Preparar datos para la API, asumiendo que recibe base64
        $response = Http::post('http://localhost:3000/api/v1/auth/images', [
            'ordenId' => $orderId,
            'nombre' => $filename,
            'archivoBase64' => $fileContents,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Imagen subida correctamente');
        } else {
            return back()->withErrors('Error al subir la imagen');
        }
    }

    public function deleteImage($imageId)
{
    $response = Http::delete("http://localhost:3000/api/v1/auth/images/{$imageId}");

    if ($response->successful()) {
        return back()->with('success', 'Imagen eliminada correctamente');
    } else {
        return back()->withErrors('Error al eliminar la imagen');
    }
}

}
