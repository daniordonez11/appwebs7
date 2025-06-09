@extends('cabeceras.app')

@section('title', 'Lista de Órdenes')

@section('content')

<h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Órdenes</h1>

<a href="{{ route('order.create') }}" 
   class="block mx-auto mb-6 bg-blue-600 text-white text-lg font-semibold px-6 py-3 rounded hover:bg-blue-700 text-center w-max">
    + Nueva Orden
</a>

<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID Usuario</th>
            <th>Nombre Cliente</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Modelo PC</th>
            <th>Número Serie</th>
            <th>Estado Inicial</th>
            <th>Accesorios Entregados</th>
            <th>Estado</th>
            <th>Última Actualización</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order['usuarioId'] }}</td>
                <td>{{ $order['nombreCliente'] }}</td>
                <td>{{ $order['telefonoCliente'] }}</td>
                <td>{{ $order['emailCliente'] }}</td>
                <td>{{ $order['modeloPc'] }}</td>
                <td>{{ $order['numeroSeriePc'] }}</td>
                <td>{{ $order['estadoInicial'] }}</td>
                <td>{{ $order['accesoriosEntregados'] }}</td>
                <td>{{ $order['estado'] }}</td>
                <td>{{ \Carbon\Carbon::parse($order['updatedAt'])->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('order.edit', $order['id']) }}" class="text-blue-500 hover:underline">Editar</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11">No hay órdenes para mostrar.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
