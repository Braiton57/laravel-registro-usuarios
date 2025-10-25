<div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
    @if (session()->has('success'))
        <div class="text-green-600 font-semibold mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="registrar" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block font-medium text-gray-700">Nombre:</label>
            <input type="text" wire:model="nombre" class="w-full border rounded px-2 py-1">
            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700">Correo:</label>
            <input type="email" wire:model="email" class="w-full border rounded px-2 py-1">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700">Imagen (opcional):</label>
            <input type="file" wire:model="imagen" class="w-full border rounded px-2 py-1">
            @error('imagen') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if ($imagen)
                <div class="mt-3">
                    <strong>Vista previa:</strong><br>
                    <img src="{{ $imagen->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-full border">
                </div>
            @endif
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">
            Registrar
        </button>
    </form>
</div>
