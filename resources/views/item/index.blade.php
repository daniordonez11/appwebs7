@extends('cabeceras.app')

@section('content')
    <h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Inventario</h1>

    <a href="{{ route('item.create') }}" 
   class="block mx-auto mb-6 bg-blue-600 text-white text-lg font-semibold px-6 py-3 rounded hover:bg-blue-700 text-center w-max">
    + Nuevo Item
</a>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Descripción</th>
                <th class="border border-gray-300 px-4 py-2">Cantidad</th>
                <th class="border border-gray-300 px-4 py-2">Observación</th>
                <th class="border border-gray-300 px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $item['id'] ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item['descripcion'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item['cantidad'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item['observacion'] }}</td>
                    <td>
                        <a href="{{ route('item.edit', $item['id']) }}" class="text-blue-600 hover:underline">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
