@extends('cabeceras.app')

@section('content')
<h1 class="text-3xl font-bold text-center mb-6">Crear Orden</h1>

<form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto space-y-4 bg-white p-6 rounded shadow-md">
    @csrf

    <input
        name="nombreCliente"
        placeholder="Nombre del Cliente"
        value="{{ old('nombreCliente') }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
        required
    >

    <input
        name="telefonoCliente"
        type="number"
        placeholder="Teléfono Cliente"
        value="{{ old('telefonoCliente') }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
        required
    >

    <input
        name="emailCliente"
        type="email"
        placeholder="Email Cliente (opcional)"
        value="{{ old('emailCliente') }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
    >

    <input
        name="modeloPc"
        placeholder="Modelo PC"
        value="{{ old('modeloPc') }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
        required
    >

    <input
        name="numeroSeriePc"
        type="number"
        step="any"
        placeholder="Número Serie PC (opcional)"
        value="{{ old('numeroSeriePc') }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
    >

    <input
        name="estadoInicial"
        placeholder="Estado Inicial (opcional)"
        value="{{ old('estadoInicial') }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
    >

    <input
        name="accesoriosEntregados"
        placeholder="Accesorios entregados (opcional)"
        value="{{ old('accesoriosEntregados') }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
    >

    <select name="estado" class="w-full border border-gray-300 rounded px-3 py-2" required>
        <option value="Recien llegado" {{ old('estado') == 'Recien llegado' ? 'selected' : '' }}>Recien llegado</option>
        <option value="En proceso" {{ old('estado') == 'En proceso' ? 'selected' : '' }}>En Proceso</option>
        <option value="Listo para entrega" {{ old('estado') == 'Listo para entrega' ? 'selected' : '' }}>FListo para entrega</option>
        <option value="Recientemente entregado" {{ old('estado') == 'Recientemente entregado' ? 'selected' : '' }}>Recientemente entregado</option>
    </select>

    <select name="usuarioId" class="w-full border border-gray-300 rounded px-3 py-2" required>
        <option value="">Selecciona un Usuario</option>
        @foreach($usuarios as $usuario)
            <option value="{{ $usuario['id'] }}" {{ old('usuarioId') == $usuario['id'] ? 'selected' : '' }}>
                {{ $usuario['nombre'] ?? $usuario['name'] }}
            </option>
        @endforeach
    </select>

    <label for="image" class="block font-semibold">Imagen (opcional)</label>
    <input
    type="file"
    name="image"
    id="image"
    accept="image/*"
    class="w-full border border-gray-300 rounded px-3 py-2"
/>

    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold">
        Guardar
    </button>
</form>

@endsection

