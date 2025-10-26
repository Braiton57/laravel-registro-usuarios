<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminUsuarios extends Component
{
    use WithFileUploads, WithPagination;

    public $usuario_id;
    public $nombre;
    public $email;
    public $imagen;
    public $modoEdicion = false;
    public $password;

    protected $paginationTheme = 'tailwind'; 
    public function render()
    {
        
        $usuarios = User::orderBy('id', 'desc')->paginate(10);

        return view('livewire.admin-usuarios', [
            'usuarios' => $usuarios
        ]);
    }

    public function guardarUsuario()
    {
        $reglas = [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->usuario_id,
            'imagen' => 'nullable|image|max:2048',
        ];

        if (!$this->usuario_id) {
            $reglas['password'] = 'required|min:6';
        }

        $this->validate($reglas);

        $rutaImagen = $this->imagen ? $this->imagen->store('imagenes', 'public') : null;

        if ($this->usuario_id) {
            $usuario = User::findOrFail($this->usuario_id);

            if ($rutaImagen && $usuario->imagen) {
                Storage::disk('public')->delete($usuario->imagen);
            }

            $usuario->update([
                'name' => $this->nombre,
                'email' => $this->email,
                'imagen' => $rutaImagen ?? $usuario->imagen,
                'password' => $this->password ? Hash::make($this->password) : $usuario->password,
            ]);

            session()->flash('message', 'Usuario actualizado correctamente.');
        } else {
            User::create([
                'name' => $this->nombre,
                'email' => $this->email,
                'imagen' => $rutaImagen,
                'password' => Hash::make($this->password),
            ]);

            session()->flash('message', 'Usuario creado correctamente.');
        }

        $this->reset(['nombre', 'email', 'imagen', 'password', 'usuario_id', 'modoEdicion']);
        $this->resetValidation();
        $this->resetPage();
    }

    public function editarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $this->usuario_id = $usuario->id;
        $this->nombre = $usuario->name;
        $this->email = $usuario->email;
        $this->password = '';
        $this->imagen = null;
        $this->modoEdicion = true;
    }

    public function eliminarUsuario($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->imagen) {
            Storage::disk('public')->delete($usuario->imagen);
        }

        $usuario->delete();

        session()->flash('message', 'Usuario eliminado correctamente.');
        $this->resetPage();
    }

    public function eliminarImagen($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->imagen) {
            Storage::disk('public')->delete($usuario->imagen);
            $usuario->update(['imagen' => null]);
        }

        session()->flash('message', 'Imagen eliminada correctamente.');
    }

    public function cancelarEdicion()
    {
        $this->reset(['nombre', 'email', 'imagen', 'password', 'usuario_id', 'modoEdicion']);
    }
}