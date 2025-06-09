@extends('cabeceras.app')

@section('content')
    <h1 class="text-3xl font-bold text-center mb-6">Crear Nuevo Item</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 max-w-xl mx-auto">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('item.store') }}" method="POST" class="max-w-xl mx-auto space-y-4 bg-white p-6 rounded shadow-md">
        @csrf

        <div>
            <label class="block mb-1 font-semibold">Descripción:</label>
            <input type="text" name="descripcion" value="{{ old('descripcion') }}"
                class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Cantidad:</label>
            <input type="number" name="cantidad" value="{{ old('cantidad') }}"
                class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Observación:</label>
            <textarea name="observacion"
                class="w-full border border-gray-300 rounded px-3 py-2">{{ old('observacion') }}</textarea>
        </div>

        <button type="submit"
            class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-semibold">
            Guardar
        </button>
    </form>
@endsection
