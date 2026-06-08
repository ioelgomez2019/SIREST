@extends('Backend.Layout.app')

@section('main-content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detalle de Venta</h4>
                <a class="btn bg-gradient-primary mb-0" href="{{ route('ventas_imprimir', $venta_actual->id_venta) }}" target="_blank">
                    Imprimir Ticket <i class="material-icons">print</i>
                </a>
            </div>

            <div class="col-12">
                <div class="card my-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">
                                Venta #{{ str_pad($venta_actual->id_venta, 6, '0', STR_PAD_LEFT) }}
                            </h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-uppercase text-sm">Datos del cliente</h6>
                                <p class="text-sm mb-1"><strong>Nombre:</strong> {{ $venta_actual->nombres }} {{ $venta_actual->apellidos }}</p>
                                <p class="text-sm mb-1"><strong>Teléfono:</strong> {{ $venta_actual->telefono }}</p>
                                <p class="text-sm mb-0"><strong>Correo:</strong> {{ $venta_actual->email }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-uppercase text-sm">Datos de la venta</h6>
                                <p class="text-sm mb-1">
                                    <strong>Fecha:</strong>
                                    {{ \Carbon\Carbon::parse($venta_actual->fecha_venta)->format('d/m/Y h:i A') }}
                                </p>
                                <p class="text-sm mb-1"><strong>Atendido por:</strong> {{ $venta_actual->vendedor_venta }}</p>
                                <p class="text-sm mb-0">
                                    <strong>Forma de pago:</strong>
                                    <span class="text-uppercase">{{ $venta_actual->tipodepago_venta }}</span>
                                </p>
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        <h6 class="text-uppercase text-sm">Productos</h6>
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Producto</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($venta_actual->lista_venta) as $item)
                                        @php
                                            $subtotal = $item->precio * $item->cantidad;
                                        @endphp
                                        <tr>
                                            <td class="text-sm">{{ $item->nombre }}</td>
                                            <td class="text-sm text-center">{{ $item->cantidad }}</td>
                                            <td class="text-sm text-end">$ {{ number_format($item->precio, 2) }}</td>
                                            <td class="text-sm text-end">$ {{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr class="horizontal dark">

                        <div class="d-flex justify-content-end">
                            <h6 class="text-uppercase mb-0">Total: <span class="text-success">$ {{ number_format($venta_actual->total_venta, 2) }}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
