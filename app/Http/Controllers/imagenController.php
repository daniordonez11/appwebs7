<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Cloudinary\Cloudinary;

class ImagenController extends Controller
{
    protected $cloudinary;

    public function __construct()
    {
        // Configura Cloudinary (puedes usar config/env)
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);
    }

    // Listar imágenes por ordenId
    public function index($ordenId)
    {
        $imagenes = Imagen::where('ordenId', $ordenId)->get();
        return response()->json($imagenes);
    }

    // Subir imagen para una orden
    public function upload(Request $request, $ordenId)
    {
        $request->validate([
            'imagen' => 'required|image|max:5120', // max 5MB
        ]);

        $file = $request->file('imagen');

        // Subir a Cloudinary
        $uploadedFileUrl = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'ordenes/'.$ordenId,
        ]);

        // Guardar en BD
        $imagen = new Imagen();
        $imagen->nombre = $file->getClientOriginalName();
        $imagen->urlImagen = $uploadedFileUrl['secure_url'];
        $imagen->ordenId = $ordenId;
        $imagen->save();

        return response()->json([
            'message' => 'Imagen subida correctamente',
            'imagen' => $imagen,
        ], 201);
    }

    // (Opcional) Borrar imagen
    public function destroy($id)
    {
        $imagen = Imagen::findOrFail($id);
        // Aquí podrías agregar borrar la imagen en Cloudinary si quieres
        $imagen->delete();

        return response()->json(['message' => 'Imagen eliminada']);
    }
}
