@extends('cabeceras.app')

@section('content')

<a href="{{ route('users.create') }}" 
   class="block mx-auto mb-6 bg-blue-600 text-white text-lg font-semibold px-6 py-3 rounded hover:bg-blue-700 text-center w-max">
    + Nuevo
</a>

<h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Empleados</h1>

<div class="max-w-screen-xl mx-auto px-6 py-4 bg-white shadow-lg rounded-lg mb-12">
    <table id="tabla-empleados" class="w-full border border-green-300 ordenable">
        <thead class="bg-green-600 text-white cursor-pointer select-none">
            <tr>
                <th class="px-5 py-3 border-r border-green-500" data-col="0">Nombre <span class="sort-indicator ml-1 text-sm"></span></th>
                <th class="px-5 py-3 border-r border-green-500" data-col="1">Correo <span class="sort-indicator ml-1 text-sm"></span></th>
                <th class="px-5 py-3" style="cursor: default;">Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usersConAcceso as $user)
                <tr class="border-t border-green-200 hover:bg-green-50 transition-colors duration-200">
                    <td class="px-5 py-3 border-r border-green-200">{{ $user['nombre'] ?? $user['name'] ?? 'N/A' }}</td>
                    <td class="px-5 py-3 border-r border-green-200 break-words max-w-xs">{{ $user['email'] ?? 'N/A' }}</td>
                    <td class="px-5 py-3 text-center">
                        <a href="{{ url('/users/edit/' . $user['id']) }}" class="text-green-700 hover:text-green-900 font-semibold hover:underline">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-6 text-green-700 font-semibold">No hay usuarios con acceso total.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Clientes</h1>

<div class="max-w-screen-xl mx-auto px-6 py-4 bg-white shadow-lg rounded-lg">
    <table id="tabla-clientes" class="w-full border border-green-300 ordenable">
        <thead class="bg-green-600 text-white cursor-pointer select-none">
            <tr>
                <th class="px-5 py-3 border-r border-green-500" data-col="0">Nombre <span class="sort-indicator ml-1 text-sm"></span></th>
                <th class="px-5 py-3 border-r border-green-500" data-col="1">Correo <span class="sort-indicator ml-1 text-sm"></span></th>
                <th class="px-5 py-3" style="cursor: default;">Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usersSinAcceso as $user)
                <tr class="border-t border-green-200 hover:bg-green-50 transition-colors duration-200">
                    <td class="px-5 py-3 border-r border-green-200">{{ $user['nombre'] ?? $user['name'] ?? 'N/A' }}</td>
                    <td class="px-5 py-3 border-r border-green-200 break-words max-w-xs">{{ $user['email'] ?? 'N/A' }}</td>
                    <td class="px-5 py-3 text-center">
                        <a href="{{ url('/users/edit/' . $user['id']) }}" class="text-green-700 hover:text-green-900 font-semibold hover:underline">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-6 text-green-700 font-semibold">No hay usuarios sin acceso total.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Script para ordenar columnas --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    function initOrdenable(tablaId) {
        const tabla = document.getElementById(tablaId);
        if (!tabla) return;
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
            if(th.style.cursor === 'default') return; // No ordenar columna "Acción"

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
    }

    initOrdenable('tabla-empleados');
    initOrdenable('tabla-clientes');
});
</script>

@endsection
