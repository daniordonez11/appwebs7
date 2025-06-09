@extends('cabeceras.app')

@section('content')
<h1 class="text-3xl font-bold text-center mb-6">Editar Orden</h1>

<form action="{{ route('order.update', $orden['id']) }}" method="POST" class="max-w-xl mx-auto">
    @csrf
    @method('PUT')

    <input name="nombreCliente" placeholder="Nombre del Cliente" class="input-field" 
        value="{{ old('nombreCliente', $orden['nombreCliente']) }}" required>
    
    <input name="telefono" type="number" placeholder="Teléfono" class="input-field" 
        value="{{ old('telefono', $orden['telefono']) }}" required>
    
    <input name="modeloPc" placeholder="Modelo PC" class="input-field" 
        value="{{ old('modeloPc', $orden['modeloPc']) }}" required>
    
    <textarea name="descripcion" placeholder="Descripción" class="input-field" required>{{ old('descripcion', $orden['descripcion']) }}</textarea>
    
    <input name="accesorios" placeholder="Accesorios (opcional)" class="input-field" 
        value="{{ old('accesorios', $orden['accesorios'] ?? '') }}">
    
    <select name="estado" class="input-field" required>
        <option value="en proceso" {{ old('estado', $orden['estado']) == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
        <option value="finalizado" {{ old('estado', $orden['estado']) == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
    </select>

    <select name="usuarioId" class="input-field" required>
        <option value="">Selecciona un Usuario</option>
        @foreach($usuarios as $usuario)
            <option value="{{ $usuario['id'] }}" 
                {{ old('usuarioId', $orden['usuarioId']) == $usuario['id'] ? 'selected' : '' }}>
                {{ $usuario['nombre'] ?? $usuario['name'] }}
            </option>
        @endforeach
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
</form>
@endsection
