@extends('cabeceras.app')

@section('content')
<h1 class="text-3xl font-bold text-center mb-6">Editar Usuario</h1>

<form action="{{ route('users.update', $user['id']) }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')

    <label class="block mb-2">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $user['nombre']) }}" class="w-full border p-2 rounded mb-4" required>

    <label class="block mb-2">Correo Electrónico</label>
    <input type="email" name="email" value="{{ old('email', $user['email']) }}" class="w-full border p-2 rounded mb-4" required>

    <label class="block mb-2">Contraseña (dejar en blanco para no cambiar)</label>
    <input type="password" name="password" class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">¿Qué tipo de Usuario es?</label>
    <select name="accesoTotal" class="w-full border p-2 rounded mb-4" required>
        <option value="1" {{ old('accesoTotal', $user['accesoTotal']) == 1 ? 'selected' : '' }}>Empleado</option>
        <option value="0" {{ old('accesoTotal', $user['accesoTotal']) == 0 ? 'selected' : '' }}>Cliente</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
</form>
@endsection
