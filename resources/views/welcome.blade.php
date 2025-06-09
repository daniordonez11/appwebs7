@extends('cabeceras.app')

@section('content')
<h1 class="text-center text-3xl font-bold mb-6">Órdenes según estado</h1>

@php
    $secciones = [
        ['titulo' => 'Recien llegadas', 'datos' => $recienLlegadas],
        ['titulo' => 'En proceso', 'datos' => $enProceso],
        ['titulo' => 'Recientemente entregado', 'datos' => $recientementeEntregado],
        ['titulo' => 'Otros estados', 'datos' => $otrosEstados],
    ];
@endphp

@foreach ($secciones as $seccion)
    <h2 class="text-xl font-semibold mt-6">{{ $seccion['titulo'] }}</h2>
    <table class="table-auto w-full border-collapse border border-gray-300 mb-6">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Cliente</th>
                <th class="border border-gray-300 px-4 py-2">Teléfono</th>
                <th class="border border-gray-300 px-4 py-2">Email</th>
                <th class="border border-gray-300 px-4 py-2">Modelo PC</th>
                <th class="border border-gray-300 px-4 py-2">N° Serie</th>
                <th class="border border-gray-300 px-4 py-2">Estado Inicial</th>
                <th class="border border-gray-300 px-4 py-2">Accesorios</th>
                <th class="border border-gray-300 px-4 py-2">Estado</th>
                <th class="border border-gray-300 px-4 py-2">Última Actualización</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($seccion['datos'] as $orden)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['id'] ?? 'N/A' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['nombreCliente'] ?? '' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['telefonoCliente'] ?? '' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['emailCliente'] ?? '' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['modeloPc'] ?? '' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['numeroSeriePc'] ?? '' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['estadoInicial'] ?? '' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['accesoriosEntregados'] ?? '' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['estado'] ?? '' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $orden['updatedAt'] ?? '' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center p-2">No hay órdenes</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endforeach

@endsection
