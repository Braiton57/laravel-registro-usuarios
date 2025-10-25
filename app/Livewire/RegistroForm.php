<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistroForm extends Component
{
    use WithFileUploads;

    public $nombre;
    public $email;
    public $imagen;

    protected $rules = [
        'nombre' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'imagen' => 'nullable|image|max:2048', // Máx 2MB
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function registrar()
    {
        $validatedData = $this->validate();

        $path = null;

        if ($this->imagen) {
            // 🔹 Guarda siempre en storage/app/public/imagenes
            $path = $this->imagen->store('imagenes', 'public');
        }

        User::create([
            'name' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'password' => Hash::make('12345678'),
            'imagen' => $path, // 🔹 Campo coherente con el admin
        ]);

        $this->reset(['nombre', 'email', 'imagen']);
        session()->flash('success', 'Usuario registrado correctamente.');
    }

    public function render()
    {
        return view('livewire.registro-form');
    }
}