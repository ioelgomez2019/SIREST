<?php

namespace App\Http\Livewire\Backend\ClientesLive;

use App\Models\Cliente;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;


class Crearclient extends Component
{
    public Cliente $cliente;

    public function mount()
    {
        $this->cliente = new Cliente();
    }

    public function rules()
    {
        return [
            'cliente.nombres' => 'required',
            'cliente.apellidos' => 'required',
            'cliente.cod' => 'required',
            'cliente.telefono' => 'required',
            'cliente.email' => 'required',
            'cliente.password' => 'required',
            'cliente.direccionfiscal' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cliente.nombres.required' => 'El campo Nombres es requerido',
            'cliente.apellidos.required' => 'El campo Apellidos es requerido',
            'cliente.cod.required' => 'El Código del teléfono es requerido',
            'cliente.telefono.required' => 'El Teléfono es requerido',
            'cliente.email.required' => 'El Correo es requerido',
            'cliente.password.required' => 'La Contraseña es requerida',
            'cliente.direccionfiscal.required' => 'La Dirección es requerida'
        ];
    }

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function render()
    {
        return view('livewire.backend.clientes-live.crearclient');
    }

    public function guardar_client()
    {
        $this->validate();
        // $this->cliente->save();
        $this->cliente = Cliente::create([
            'nombres' => $this->cliente['nombres'],
            'apellidos' => $this->cliente['apellidos'],
            'cod' => $this->cliente['cod'],
            'telefono' => $this->cliente['telefono'],
            'email' => $this->cliente['email'],
            'password' => Hash::make($this->cliente['password']),
            'direccionfiscal' => $this->cliente['direccionfiscal'],
        ]);
        $this->cliente = new Cliente();

        session()->flash('cerrarModal');

        $this->emitTo('backend.clientes-live.listarclient', 'actualizarClientes');
    }
}
