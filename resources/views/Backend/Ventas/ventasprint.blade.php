@extends('Backend.Layout.app')

@push('custom-css')
    <style>
        .ticket {
            width: 320px;
            margin: 0 auto;
            padding: 20px 16px;
            background-color: #fff;
            color: #000;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.4;
        }

        .ticket hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .ticket .ticket-header {
            text-align: center;
        }

        .ticket .ticket-header h6 {
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            margin: 6px 0 2px;
        }

        .ticket .ticket-header p {
            color: #000;
            margin: 0;
        }

        .ticket .ticket-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            color: #000;
        }

        .ticket table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            color: #000;
        }

        .ticket table th {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 11px;
            border-bottom: 1px dashed #000;
            padding-bottom: 4px;
        }

        .ticket table td {
            padding: 3px 0;
            font-size: 11px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .ticket table .col-producto {
            width: 38%;
        }

        .ticket table .col-cant {
            width: 14%;
        }

        .ticket table .col-precio,
        .ticket table .col-subtotal {
            width: 24%;
        }

        .ticket .text-end {
            text-align: right;
        }

        .ticket .text-center {
            text-align: center;
        }

        .ticket .ticket-total {
            font-weight: bold;
            font-size: 14px;
        }

        .ticket .ticket-footer {
            text-align: center;
            margin-top: 10px;
        }

        @media print {

            #botonImprimir,
            .sidenav,
            .navbar,
            footer {
                display: none !important;
            }

            body * {
                visibility: hidden;
            }

            #printSection,
            #printSection * {
                visibility: visible;
            }

            #printSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .ticket {
                box-shadow: none;
            }
        }
    </style>
@endpush

@section('main-content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mb-3" id="botonImprimir">
                <a class="btn bg-gradient-primary" href="javascript:void(0)" onclick="window.print()">
                    Imprimir <i class="material-icons">print</i>
                </a>
            </div>

            <div class="col-12 d-flex justify-content-center">
                <div class="card my-2">
                    <div class="card-body p-4" id="printSection">
                        <div class="ticket">
                            <div class="ticket-header">
                                @if ($negocio[0]->neg_img)
                                    <img src="{{ asset('storage/' . $negocio[0]->neg_img) }}" width="64">
                                @endif
                                <h6>{{ $negocio[0]->neg_nombre }}</h6>
                                <p>{{ $negocio[0]->neg_direccion }} - {{ $negocio[0]->neg_pais }}</p>
                                <p>Tel: +{{ $negocio[0]->neg_cod }} {{ $negocio[0]->neg_telefono }}</p>
                                @if ($negocio[0]->neg_correo)
                                    <p>{{ $negocio[0]->neg_correo }}</p>
                                @endif
                            </div>

                            <hr>

                            @php
                                $numero = $venta_actual->id_venta;
                                $folio = 'VEN-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
                            @endphp

                            <div class="ticket-row">
                                <span>No. Ticket:</span>
                                <span>{{ $folio }}</span>
                            </div>
                            <div class="ticket-row">
                                <span>Fecha:</span>
                                <span>{{ \Carbon\Carbon::parse($venta_actual->fecha_venta)->format('d/m/Y h:i A') }}</span>
                            </div>
                            <div class="ticket-row">
                                <span>Cliente:</span>
                                <span>{{ $venta_actual->nombres }} {{ $venta_actual->apellidos }}</span>
                            </div>
                            <div class="ticket-row">
                                <span>Atendido por:</span>
                                <span>{{ $venta_actual->vendedor_venta }}</span>
                            </div>
                            <div class="ticket-row">
                                <span>Forma de pago:</span>
                                <span class="text-uppercase">{{ $venta_actual->tipodepago_venta }}</span>
                            </div>

                            <hr>

                            <table>
                                <thead>
                                    <tr>
                                        <th class="col-producto text-start">Producto</th>
                                        <th class="col-cant text-center">Cant</th>
                                        <th class="col-precio text-end">Precio</th>
                                        <th class="col-subtotal text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($venta_actual->lista_venta) as $item)
                                        @php
                                            $subtotal = $item->precio * $item->cantidad;
                                        @endphp
                                        <tr>
                                            <td class="col-producto">{{ $item->nombre }}</td>
                                            <td class="col-cant text-center">{{ $item->cantidad }}</td>
                                            <td class="col-precio text-end">$ {{ number_format($item->precio, 2) }}</td>
                                            <td class="col-subtotal text-end">$ {{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <hr>

                            <div class="ticket-row ticket-total">
                                <span>TOTAL</span>
                                <span>$ {{ number_format($venta_actual->total_venta, 2) }}</span>
                            </div>

                            <hr>

                            <div class="ticket-footer">
                                <p>¡Gracias por su compra!</p>
                                <p>{{ $negocio[0]->neg_nombre }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
