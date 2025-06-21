@extends('cabeceras.app')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-6 max-w-screen-xl mx-auto">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 text-red-800 p-4 rounded mb-6 max-w-screen-xl mx-auto">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<a href="{{ route('users.create') }}" 
   class="block mx-auto mb-6 bg-blue-600 text-white text-lg font-semibold px-6 py-3 rounded hover:bg-blue-700 text-center w-max">
    + Nuevo
</a>

<h1 style="font-weight: bold; font-size: 64px; text-align: center;">Empleados</h1>

<div class="max-w-screen-xl mx-auto px-6 py-4 bg-white shadow-lg rounded-lg mb-12">
    <table id="tabla-empleados" class="w-full border border-green-300 ordenable">
        <thead class="bg-green-600 text-white cursor-pointer select-none">
            <tr>
                <th class="px-5 py-3 border-r border-green-500" data-col="0">Nombre <span class="sort-indicator ml-1 text-sm"></span></th>
                <th class="px-5 py-3 border-r border-green-500" data-col="1">Correo <span class="sort-indicator ml-1 text-sm"></span></th>
                <th class="px-5 py-3" style="cursor: default;">Acción</th>
                <th class="px-5 py-3" style="cursor: default;">Borrar</th>
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
                    <td class="px-5 py-3 text-center">
                        <button class="text-red-600 hover:text-red-800 font-semibold hover:underline bg-transparent border-none cursor-pointer borrar-btn" data-userid="{{ $user['id'] }}" data-username="{{ $user['nombre'] ?? $user['name'] ?? 'N/A' }}">
                            Borrar
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-green-700 font-semibold">No hay usuarios con acceso total.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<h1 style="font-weight: bold; font-size: 64px; text-align: center;">Clientes</h1>

<div class="max-w-screen-xl mx-auto px-6 py-4 bg-white shadow-lg rounded-lg">
    <table id="tabla-clientes" class="w-full border border-green-300 ordenable">
        <thead class="bg-green-600 text-white cursor-pointer select-none">
            <tr>
                <th class="px-5 py-3 border-r border-green-500" data-col="0">Nombre <span class="sort-indicator ml-1 text-sm"></span></th>
                <th class="px-5 py-3 border-r border-green-500" data-col="1">Correo <span class="sort-indicator ml-1 text-sm"></span></th>
                <th class="px-5 py-3" style="cursor: default;">Acción</th>
                <th class="px-5 py-3" style="cursor: default;">Borrar</th>
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
                    <td class="px-5 py-3 text-center">
                        <button class="text-red-600 hover:text-red-800 font-semibold hover:underline bg-transparent border-none cursor-pointer borrar-btn" data-userid="{{ $user['id'] }}" data-username="{{ $user['nombre'] ?? $user['name'] ?? 'N/A' }}">
                            Borrar
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-green-700 font-semibold">No hay usuarios sin acceso total.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal de confirmación --}}
<div id="modalConfirmar" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
        <h2 class="text-xl font-semibold mb-4">Confirmar borrado</h2>
        <p class="mb-6" id="mensajeConfirmacion">¿Estás seguro de borrar este usuario?</p>
        <form id="formBorrar" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded mr-4">Sí, borrar</button>
            <button type="button" id="btnCancelar" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold px-4 py-2 rounded">Cancelar</button>
        </form>
    </div>
</div>

{{-- Script para ordenar columnas y modal borrar --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Función para ordenar columnas
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
            if(th.style.cursor === 'default') return; // No ordenar columnas "Acción" y "Borrar"

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

    // Modal borrar
    const modal = document.getElementById('modalConfirmar');
    const mensaje = document.getElementById('mensajeConfirmacion');
    const formBorrar = document.getElementById('formBorrar');
    const btnCancelar = document.getElementById('btnCancelar');

    document.querySelectorAll('.borrar-btn').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.userid;
            const userName = button.dataset.username;
            formBorrar.action = `/users/delete/${userId}`;
            mensaje.textContent = `¿Estás seguro de borrar al usuario "${userName}"?`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    btnCancelar.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });
});
</script>

@endsection
