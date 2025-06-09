@extends('cabeceras.app')

@section('content')
    <h1 class="text-3xl font-bold text-center mb-6">Editar Item</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 max-w-xl mx-auto">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('item.update', $item['id']) }}" method="POST"
        class="max-w-xl mx-auto space-y-4 bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-semibold" for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion"
                value="{{ old('descripcion', $item['descripcion']) }}"
                class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold" for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad"
                value="{{ old('cantidad', $item['cantidad']) }}"
                class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold" for="observacion">Observación</label>
            <input type="text" name="observacion" id="observacion"
                value="{{ old('observacion', $item['observacion']) }}"
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-semibold">
                Guardar cambios
            </button>
            <a href="{{ route('item.index') }}" class="text-gray-600 hover:underline ml-4">Cancelar</a>
        </div>
    </form>
@endsection
