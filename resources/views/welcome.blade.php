@extends('cabeceras.app')

@section('content')
<h1 class="text-center text-3xl font-extrabold mb-8 text-green-800">Órdenes según estado</h1>

@php
    $secciones = [
        ['titulo' => 'Recien llegadas', 'datos' => $recienLlegadas],
        ['titulo' => 'En proceso', 'datos' => $enProceso],
        ['titulo' => 'Recientemente entregado', 'datos' => $recientementeEntregado],
        ['titulo' => 'Otros estados', 'datos' => $otrosEstados],
    ];
@endphp

@foreach ($secciones as $index => $seccion)
    <section class="mb-10">
        <h2 class="text-2xl font-semibold mb-4 text-green-700 border-l-4 border-green-600 pl-3">{{ $seccion['titulo'] }}</h2>

        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table id="tabla-ordenes-{{ $index }}" class="min-w-full bg-white border border-green-300 ordenable">
                <thead class="bg-green-600 text-white cursor-pointer select-none">
                    <tr>
                        @php
                            $headers = ['ID', 'Cliente', 'Teléfono', 'Email', 'Modelo PC', 'N° Serie', 'Estado Inicial', 'Accesorios', 'Estado', 'Última Actualización'];
                        @endphp
                        @foreach ($headers as $colIndex => $header)
                            <th
                                class="px-4 py-3 text-left uppercase font-medium tracking-wider border-r border-green-500"
                                data-col="{{ $colIndex }}"
                            >
                                {{ $header }}
                                <span class="sort-indicator ml-1 text-sm"></span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($seccion['datos'] as $orden)
                        <tr class="border-t border-green-200 hover:bg-green-50 transition-colors duration-200">
                            <td class="px-4 py-2 whitespace-nowrap border-r border-green-200 font-semibold">{{ $orden['id'] ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border-r border-green-200">{{ $orden['nombreCliente'] ?? '' }}</td>
                            <td class="px-4 py-2 border-r border-green-200">{{ $orden['telefonoCliente'] ?? '' }}</td>
                            <td class="px-4 py-2 border-r border-green-200 break-words max-w-xs">{{ $orden['emailCliente'] ?? '' }}</td>
                            <td class="px-4 py-2 border-r border-green-200">{{ $orden['modeloPc'] ?? '' }}</td>
                            <td class="px-4 py-2 border-r border-green-200">{{ $orden['numeroSeriePc'] ?? '' }}</td>
                            <td class="px-4 py-2 border-r border-green-200">{{ $orden['estadoInicial'] ?? '' }}</td>
                            <td class="px-4 py-2 border-r border-green-200 max-w-xs truncate" title="{{ $orden['accesoriosEntregados'] ?? '' }}">
                                {{ $orden['accesoriosEntregados'] ?? '' }}
                            </td>
                            <td class="px-4 py-2 border-r border-green-200">{{ $orden['estado'] ?? '' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($orden['updatedAt'])->format('d/m/Y H:i') ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-green-700 font-semibold">No hay órdenes</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Función para comparar valores (números o texto)
    function comparar(a, b, asc) {
        // Intenta convertir a número
        const numA = parseFloat(a.replace(/[^\d.-]/g, ''));
        const numB = parseFloat(b.replace(/[^\d.-]/g, ''));
        if (!isNaN(numA) && !isNaN(numB)) {
            return asc ? numA - numB : numB - numA;
        }
        // Si no son números, compara strings
        return asc ? a.localeCompare(b) : b.localeCompare(a);
    }

    // Para cada tabla ordenable
    document.querySelectorAll('table.ordenable').forEach(tabla => {
        const thead = tabla.querySelector('thead');
        const tbody = tabla.querySelector('tbody');
        let ordenAsc = true; // por defecto ascendente
        let colOrden = -1;

        thead.querySelectorAll('th').forEach(th => {
            th.addEventListener('click', () => {
                const colIndex = parseInt(th.dataset.col);
                if (colOrden === colIndex) {
                    ordenAsc = !ordenAsc; // invierte orden
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

                // Obtener filas como array
                const filas = Array.from(tbody.querySelectorAll('tr'));

                filas.sort((filaA, filaB) => {
                    const celdaA = filaA.children[colIndex].textContent.trim();
                    const celdaB = filaB.children[colIndex].textContent.trim();
                    return comparar(celdaA, celdaB, ordenAsc);
                });

                // Reinsertar filas ordenadas
                filas.forEach(fila => tbody.appendChild(fila));
            });
        });
    });
});
</script>

@endsection
