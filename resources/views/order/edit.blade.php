@extends('cabeceras.app')

@section('content')
<h1 class="text-3xl font-bold text-center mb-6">Editar Orden</h1>

<!-- FORMULARIO PARA EDITAR ORDEN -->
<form action="{{ route('order.update', $orden['id']) }}" method="POST" class="max-w-xl mx-auto space-y-4 bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <label for="nombreCliente" class="block font-semibold">Nombre Cliente</label>
    <input
        id="nombreCliente"
        name="nombreCliente"
        value="{{ old('nombreCliente', $orden['nombreCliente']) }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
        required
    >

    <label for="telefonoCliente" class="block font-semibold">Teléfono Cliente</label>
    <input
        id="telefonoCliente"
        name="telefonoCliente"
        type="number"
        value="{{ old('telefonoCliente', $orden['telefonoCliente']) }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
        required
    >

    <label for="emailCliente" class="block font-semibold">Email Cliente</label>
    <input
        id="emailCliente"
        name="emailCliente"
        type="email"
        value="{{ old('emailCliente', $orden['emailCliente']) }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
    >

    <label for="modeloPc" class="block font-semibold">Modelo PC</label>
    <input
        id="modeloPc"
        name="modeloPc"
        value="{{ old('modeloPc', $orden['modeloPc']) }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
        required
    >

    <label for="numeroSeriePc" class="block font-semibold">Número Serie PC</label>
    <input
        id="numeroSeriePc"
        name="numeroSeriePc"
        value="{{ old('numeroSeriePc', $orden['numeroSeriePc']) }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
    >

    <label for="estadoInicial" class="block font-semibold">Estado Inicial</label>
    <input
        id="estadoInicial"
        name="estadoInicial"
        value="{{ old('estadoInicial', $orden['estadoInicial']) }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
    >

    <label for="accesoriosEntregados" class="block font-semibold">Accesorios Entregados</label>
    <input
        id="accesoriosEntregados"
        name="accesoriosEntregados"
        value="{{ old('accesoriosEntregados', $orden['accesoriosEntregados']) }}"
        class="w-full border border-gray-300 rounded px-3 py-2"
    >

    <label for="estado" class="block font-semibold">Estado</label>
    <select
        id="estado"
        name="estado"
        class="w-full border border-gray-300 rounded px-3 py-2"
        required
    >
        <option value="recien llegado" {{ (old('estado', $orden['estado']) == 'recien llegado') ? 'selected' : '' }}>Recien llegado</option>
        <option value="en proceso" {{ (old('estado', $orden['estado']) == 'en proceso') ? 'selected' : '' }}>En Proceso</option>
        <option value="listo para entrega" {{ (old('estado', $orden['estado']) == 'listo para entrega') ? 'selected' : '' }}>Listo para entrega</option>
        <option value="finalizado" {{ (old('estado', $orden['estado']) == 'finalizado') ? 'selected' : '' }}>Finalizado</option>
    </select>

    <label for="usuarioId" class="block font-semibold">Usuario Responsable</label>
    <select
        id="usuarioId"
        name="usuarioId"
        class="w-full border border-gray-300 rounded px-3 py-2"
        required
    >
        <option value="">Selecciona un Usuario</option>
        @foreach($usuarios as $usuario)
            <option value="{{ $usuario['id'] }}" {{ (old('usuarioId', $orden['usuarioId']) == $usuario['id']) ? 'selected' : '' }}>
                {{ $usuario['nombre'] ?? $usuario['name'] }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-semibold mt-6">
        Actualizar
    </button>
</form> <!-- ¡CIERRA EL FORMULARIO DE EDICIÓN AQUÍ! -->

<!-- FORMULARIO PARA SUBIR UNA IMAGEN -->
<form action="http://localhost:3000/api/v1/auth/images/upload" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow-md">
    @csrf

    <label for="image" class="block font-semibold mb-2">Agregar nueva imagen</label>
    <input type="file" name="image" id="image" accept="image/*" required class="mb-4" />

    <input type="hidden" name="ordenId" value="{{ $orden['id'] }}">

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold">
        Subir Imagen
    </button>
</form>

<!-- LISTADO DE IMÁGENES -->
<h2 class="text-2xl font-semibold mt-8 mb-4 max-w-xl mx-auto">Imágenes asociadas</h2>
@if($imagenes->isEmpty())
    <p class="text-gray-600 max-w-xl mx-auto">No hay imágenes para esta orden.</p>
@else
    <div class="grid grid-cols-3 gap-4 max-w-xl mx-auto">
        @foreach($imagenes as $imagen)
            <div class="border p-2 rounded shadow relative">
                <img src="{{ $imagen['urlImagen'] }}" alt="{{ $imagen['nombre'] }}" class="w-full h-auto rounded mb-2">
                <p class="text-center text-sm text-gray-700 mb-2">{{ $imagen['nombre'] }}</p>

                <!-- Botón eliminar -->
                <form action="{{ route('order.images.delete', $imagen['id']) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta imagen?');" class="text-center">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 font-semibold text-sm">
                        Eliminar
                    </button>
                    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        {{ $errors->first() }}
    </div>
@endif
                </form>
            </div>
        @endforeach
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="http://localhost:3000/api/v1/auth/images/upload"]');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault(); // Evita el submit tradicional

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                alert('Error al subir la imagen');
                return;
            }

            const data = await response.json();
            console.log('Respuesta API:', data);

            window.location.href = "{{ route('order.edit', $orden['id']) }}";

        } catch (error) {
            alert('Error al subir la imagen: ' + error.message);
        }
    });
});
</script>
@endsection
