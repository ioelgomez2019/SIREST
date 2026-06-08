<?php

namespace App\Http\Livewire\Backend\ClientesLive;

use App\Models\Cliente;
use Livewire\Component;

class Showclient extends Component
{
    public $selectedClientId;
    public $cliente_act;

    protected $listeners = ['clientSelected'];

    public function clientSelected($selectedClientId)
    {
        $this->selectedClientId = $selectedClientId;

        $this->cliente_act = Cliente::where('idcliente', $this->selectedClientId)->get();
        // dd($selectedClientId);
        // dd($this->cliente_act);
    }

    public function render()
    {
        return view('livewire.backend.clientes-live.showclient', [
            'cliente_act' => $this->cliente_act,
        ]);
    }
}
