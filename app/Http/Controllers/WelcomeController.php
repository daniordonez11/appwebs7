<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    public function index()
    {
        // Traer todas las órdenes desde la API
        $response = Http::get('http://localhost:3000/api/v1/auth/order');

        if ($response->successful()) {
            $orders = $response->json();
        } else {
            $orders = [];
        }

        
        $recienLlegadas = array_filter($orders, fn($order) => ($order['estado'] ?? '') === 'Recien llegada');
        $enProceso = array_filter($orders, fn($order) => ($order['estado'] ?? '') === 'En proceso');
        $recientementeEntregado = array_filter($orders, fn($order) => ($order['estado'] ?? '') === 'Recientemente entregado');
        $otrosEstados = array_filter($orders, fn($order) => ($order['estado'] ?? '') === 'Listo para entrega');

        return view('welcome', compact('recienLlegadas', 'enProceso', 'recientementeEntregado', 'otrosEstados'));
    }
}
