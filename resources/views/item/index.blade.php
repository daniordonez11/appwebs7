@extends('cabeceras.app')

@section('content')
    <h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Inventario</h1>

    <a href="{{ route('item.create') }}" 
   class="block mx-auto mb-6 bg-blue-600 text-white text-lg font-semibold px-6 py-3 rounded hover:bg-blue-700 text-center w-max">
    + Nuevo Item
</a>

    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table id="tabla-inventario" class="min-w-full bg-white border border-green-300 ordenable">
            <thead class="bg-green-600 text-white cursor-pointer select-none">
                <tr>
                    @php
                        $headers = ['ID', 'Descripción', 'Cantidad', 'Observación', 'Acciones'];
                    @endphp
                    @foreach ($headers as $colIndex => $header)
                        <th
                            class="px-5 py-3 text-left uppercase font-semibold tracking-wider border-r border-green-500"
                            data-col="{{ $colIndex }}"
                            @if($header === 'Acciones') style="cursor: default;" @endif
                        >
                            {{ $header }}
                            @if($header !== 'Acciones')
                            <span class="sort-indicator ml-1 text-sm"></span>
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr class="border-t border-green-200 hover:bg-green-50 transition-colors duration-200 cursor-pointer">
                        <td class="px-5 py-3 whitespace-nowrap border-r border-green-200 font-semibold">{{ $item['id'] ?? 'N/A' }}</td>
                        <td class="px-5 py-3 border-r border-green-200">{{ $item['descripcion'] }}</td>
                        <td class="px-5 py-3 border-r border-green-200">{{ $item['cantidad'] }}</td>
                        <td class="px-5 py-3 border-r border-green-200">{{ $item['observacion'] }}</td>
                        <td class="px-5 py-3 text-center">
                            <a href="{{ route('item.edit', $item['id']) }}" class="text-green-700 hover:text-green-900 font-semibold hover:underline">
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-green-700 font-semibold">No hay items en el inventario.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Script para ordenar tabla --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabla = document.getElementById('tabla-inventario');
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
            // Evitar ordenar la columna "Acciones"
            if(th.textContent.trim() === 'Acciones') return;

            th.addEventListener('click', () => {
                const colIndex = parseInt(th.dataset.col);
                if (colOrden === colIndex) {
                    ordenAsc = !ordenAsc;
                } else {
                    ordenAsc = true;
                    colOrden = colIndex;
                }

                // Quitar indicadores de otras columnas
                thead.querySelectorAll('th .sort-indicator').forEach(span => {
                    span.textContent = '';
                });

                // Poner indicador en la columna actual
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
