<?php

namespace App\Http\Livewire\Backend\ClientesLive;

use App\Models\Cliente;
use Livewire\Component;

class Listarclient extends Component
{
    protected $listeners =
    [
        'actualizarClientes' => 'render'
    ];

    public function render()
    {
        $clientes = Cliente::orderBy('nombres')->get();
        return view('livewire.backend.clientes-live.listarclient', compact('clientes'));
    }
}
