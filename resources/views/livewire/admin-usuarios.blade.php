<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Administrar Usuarios</h2>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600 font-medium">
            {{ session('message') }}
        </div>
    @endif
    
    <form wire:submit.prevent="guardarUsuario" class="mb-6 flex flex-wrap gap-2 items-center">
        <input type="text" wire:model="nombre" placeholder="Nombre" class="border rounded px-2 py-1">
        <input type="email" wire:model="email" placeholder="Correo" class="border rounded px-2 py-1">

        <input type="password" wire:model="password" placeholder="Contraseña" class="border rounded px-2 py-1">
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="file" wire:model="imagen" class="border rounded px-2 py-1">

        @if ($modoEdicion)
            <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded">Actualizar</button>
            <button type="button" wire:click="cancelarEdicion" class="bg-gray-400 text-white px-3 py-1 rounded">Cancelar</button>
        @else
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Crear</button>
        @endif
    </form>

    <table class="table-auto w-full border-collapse border border-gray-400">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Imagen</th>
                <th class="border px-4 py-2">Nombre</th>
                <th class="border px-4 py-2">Correo</th>
                <th class="border px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td class="border px-4 py-2 text-center">{{ $usuario->id }}</td>
                    <td class="border px-4 py-2 text-center">
                        @if($usuario->imagen)
                            <img src="{{ asset('storage/' . $usuario->imagen) }}" class="w-12 h-12 rounded-full object-cover mx-auto" alt="Imagen de {{ $usuario->name }}">
                        @else
                            <span class="text-gray-400 italic">Sin imagen</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $usuario->name }}</td>
                    <td class="border px-4 py-2">{{ $usuario->email }}</td>
                    <td class="border px-4 py-2 flex flex-wrap gap-1">
                        <button wire:click="editarUsuario({{ $usuario->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Editar</button>
                        <button wire:click="eliminarUsuario({{ $usuario->id }})" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                        @if($usuario->imagen)
                            <button wire:click="eliminarImagen({{ $usuario->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Eliminar imagen</button>
                            <a href="{{ asset('storage/' . $usuario->imagen) }}" 
                                download="usuario_{{ $usuario->id }}.jpg"
                                class="bg-green-500 text-white px-2 py-1 rounded"
        >
            Descargar imagen
        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
    {{ $usuarios->links() }}
</div>
</div>