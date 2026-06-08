<?php

namespace App\Http\Livewire\Backend\ReparacionLive;

use App\Models\Pedido;
use App\Models\Imagenes;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Todorep extends Component
{
    use WithPagination;

    public $listeners = [
        'pedidoActualizado' => 'render',
        'pedidoEliminado' => 'render',
        'eliminarPedido' => 'eliminarPedido',
    ];

    public $search;

    public function render()
    {
        $pedidos = Pedido::join('clientes', 'pedido.clienteid', '=', 'clientes.idcliente')
            ->leftJoin('usuarios', 'pedido.usuarioid', '=', 'usuarios.idusuarios')
            ->join('dispositivo', 'pedido.id_device', '=', 'dispositivo.id_device')
            ->select('pedido.*', 'pedido.status as estado_p', 'clientes.*', 'clientes.apellidos as persona_apellidos', 'usuarios.*', 'usuarios.apellidos as usuario_apellidos', 'usuarios.email as usuario_email', 'dispositivo.*')
            ->where('clientes.apellidos', 'LIKE', '%' . $this->search . '%')
            ->orWhere('clientes.nombres', 'LIKE', '%' . $this->search . '%')
            ->orWhere('usuarios.nombre', 'LIKE', '%' . $this->search . '%')
            ->orWhere('usuarios.apellidos', 'LIKE', '%' . $this->search . '%')
            ->orWhere('pedido.idpedido', 'LIKE', '%' . $this->search . '%')
            ->orWhere('dispositivo.device_name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('dispositivo.device_mark', 'LIKE', '%' . $this->search . '%')
            ->orWhere('pedido.fecha', 'LIKE', '%' . $this->search . '%')
            ->orWhere('pedido.fecha_entrega', 'LIKE', '%' . $this->search . '%')
            ->orderBy('pedido.idpedido', 'desc')
            ->paginate(5);
        return view('livewire.backend.reparacion-live.todorep', [
            'pedidos' => $pedidos,
        ]);
    }

    public function actualizarEstado($pedidoId, $estadoSeleccionado)
    {
        $pedido = Pedido::find($pedidoId);
        $pedido->status = $estadoSeleccionado;
        $pedido->save();

        $this->emit('pedidoActualizado');
        session()->flash('message', 'Estado de la reparación actualizada exitosamente.');
    }

    public function confirmarEliminacion($pedidoId)
    {
        $this->emit('confirmarEliminacion', $pedidoId);
    }

    public function eliminarPedido($pedidoId)
    {
        $pedido = Pedido::findOrFail($pedidoId);
        $imagenes = Imagenes::where('idpedido', $pedido->idpedido)->get();

        // Eliminar las imágenes del sistema de archivos
        foreach ($imagenes as $imagen) {
            Storage::disk('public')->delete($imagen->ruta);
        }

        // Eliminar las imágenes de la base de datos
        $imagenes->each->delete();

        // Eliminar el pedido
        $pedido->delete();

        $this->emit('pedidoEliminado');
        session()->flash('eliminado', 'Reparación eliminada exitosamente.');
    }
}
