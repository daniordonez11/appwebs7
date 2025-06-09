@extends('cabeceras.app')

@section('content')
<a href="{{ route('users.create') }}" 
   class="block mx-auto mb-6 bg-blue-600 text-white text-lg font-semibold px-6 py-3 rounded hover:bg-blue-700 text-center w-max">
    + Nuevo
</a>
    <h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Empleados</h1>
    <table>
        <thead>
            <tr><th>Nombre</th><th>Correo</th><th>Acción</th></tr>
        </thead>
        <tbody>
            @forelse ($usersConAcceso as $user)
                <tr>
                    <td>{{ $user['nombre'] ?? $user['name'] ?? 'N/A' }}</td>
                    <td>{{ $user['email'] ?? 'N/A' }}</td>
                    <td><a href="{{ url('/users/edit/' . $user['id']) }}">Editar</a></td>
                </tr>
            @empty
                <tr><td colspan="3">No hay usuarios con acceso total.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Clientes</h1>
    <table>
        <thead>
            <tr><th>Nombre</th><th>Correo</th><th>Acción</th></tr>
        </thead>
        <tbody>
            @forelse ($usersSinAcceso as $user)
                <tr>
                    <td>{{ $user['nombre'] ?? $user['name'] ?? 'N/A' }}</td>
                    <td>{{ $user['email'] ?? 'N/A' }}</td>
                    <td><a href="{{ url('/users/edit/' . $user['id']) }}">Editar</a></td>
                </tr>
            @empty
                <tr><td colspan="3">No hay usuarios sin acceso total.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
