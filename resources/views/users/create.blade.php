@extends('cabeceras.app')

@section('content')
    <h1 class="text-3xl font-bold text-center mb-6">Crear Usuario</h1>

    <form action="{{ route('users.store') }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded shadow">
        @csrf

        <label class="block mb-2">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border p-2 rounded mb-4" required>

        <label class="block mb-2">Correo Electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded mb-4" required>

        <label class="block mb-2">Contraseña</label>
        <input type="password" name="password" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">¿Que usuario es?</label>
        <select name="accesoTotal" class="w-full border p-2 rounded mb-4">
            <option value="1">Empleado</option>
            <option value="0">Cliente</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
    </form>
@endsection
