@extends('cabeceras.app')

@section('title', 'Lista de Órdenes')

@section('content')

<h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Órdenes</h1>

<a href="{{ route('order.create') }}" 
   class="block mx-auto mb-8 bg-green-700 hover:bg-green-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-md w-max transition-colors duration-300">
    + Nueva Orden
</a>

<div class="overflow-x-auto shadow-lg rounded-lg">
    <table id="tabla-ordenes" class="min-w-full bg-white border border-green-300 ordenable">
        <thead class="bg-green-600 text-white cursor-pointer select-none">
            @php
                $headers = [
                    'ID Usuario', 'Nombre Cliente', 'Teléfono', 'Email', 'Modelo PC',
                    'Número Serie', 'Estado Inicial', 'Accesorios Entregados', 'Estado',
                    'Última Actualización', 'Acciones'
                ];
            @endphp
            <tr>
                @foreach ($headers as $index => $header)
                    <th class="px-5 py-3 text-left uppercase font-semibold tracking-wider border-r border-green-500"
                        data-col="{{ $index }}"
                        @if($header === 'Acciones') style="cursor: default;" @endif>
                        {{ $header }}
                        @if($header !== 'Acciones')
                            <span class="sort-indicator ml-1 text-sm"></span>
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr class="border-t border-green-200 hover:bg-green-50 transition-colors duration-200">
                    <td class="px-5 py-3 border-r border-green-200">{{ $order['usuarioId'] }}</td>
                    <td class="px-5 py-3 border-r border-green-200">{{ $order['nombreCliente'] }}</td>
                    <td class="px-5 py-3 border-r border-green-200">{{ $order['telefonoCliente'] }}</td>
                    <td class="px-5 py-3 border-r border-green-200 break-words max-w-xs">{{ $order['emailCliente'] }}</td>
                    <td class="px-5 py-3 border-r border-green-200">{{ $order['modeloPc'] }}</td>
                    <td class="px-5 py-3 border-r border-green-200">{{ $order['numeroSeriePc'] }}</td>
                    <td class="px-5 py-3 border-r border-green-200">{{ $order['estadoInicial'] }}</td>
                    <td class="px-5 py-3 border-r border-green-200 max-w-xs truncate" title="{{ $order['accesoriosEntregados'] }}">
                        {{ $order['accesoriosEntregados'] }}
                    </td>
                    <td class="px-5 py-3 border-r border-green-200">{{ $order['estado'] }}</td>
                    <td class="px-5 py-3 border-r border-green-200 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($order['updatedAt'])->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-5 py-3 text-center">
                        <a href="{{ route('order.edit', $order['id']) }}" class="text-green-700 hover:text-green-900 font-semibold hover:underline">
                            Editar
                        </a>
                    </td>
                    <td class="px-5 py-3 text-center">
        <form method="POST" action="{{ route('order.destroy', $order['id']) }}" onsubmit="return confirm('¿Seguro quieres borrar esta orden?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold hover:underline bg-transparent border-none cursor-pointer">
                Borrar
            </button>
        </form>
    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center py-6 text-green-700 font-semibold">No hay órdenes para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Script para ordenar columnas --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabla = document.getElementById('tabla-ordenes');
    const thead = tabla.querySelector('thead');
    const tbody = tabla.querySelector('tbody');
    let ordenAsc = true;
    let colOrden = -1;

    function comparar(a, b, asc) {
        const numA = parseFloat(a.replace(/[^\d.-]/g, ''));
        const numB = parseFloat(b.replace(/[^\d.-]/g, ''));
        if (!isNaN(numA) && !isNaN(numB)) {
            return asc ? numA - numB : numB - numA;
        }
        return asc ? a.localeCompare(b) : b.localeCompare(a);
    }

    thead.querySelectorAll('th').forEach(th => {
        if(th.textContent.trim() === 'Acciones') return;

        th.addEventListener('click', () => {
            const colIndex = parseInt(th.dataset.col);
            if (colOrden === colIndex) {
                ordenAsc = !ordenAsc;
            } else {
                ordenAsc = true;
                colOrden = colIndex;
            }

            thead.querySelectorAll('th .sort-indicator').forEach(span => {
                span.textContent = '';
            });

            th.querySelector('.sort-indicator').textContent = ordenAsc ? '▲' : '▼';

            const filas = Array.from(tbody.querySelectorAll('tr'));

            filas.sort((filaA, filaB) => {
                const celdaA = filaA.children[colIndex].textContent.trim();
                const celdaB = filaB.children[colIndex].textContent.trim();
                return comparar(celdaA, celdaB, ordenAsc);
            });

            filas.forEach(fila => tbody.appendChild(fila));
        });
    });
});
</script>

@endsection
