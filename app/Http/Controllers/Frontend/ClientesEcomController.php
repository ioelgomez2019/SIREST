<?php

namespace App\Http\Controllers\frontend;

use App\Http\Requests\Frontend\ClientesEcom\ClientesEcomReq;
use App\Http\Requests\Frontend\ClientesEcom\ClienteupReq;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ClientesEcomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Frontend.Auth.registrar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientesEcomReq $request)
    {
        //return $request;
        $clientes = Cliente::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'identificacion' => $request->identificacion,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccionfiscal' => $request->direccionfiscal
        ]);

        Auth::guard('client')->login($clientes);

        return redirect()->route('home-client')->with('crear', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return view('Frontend.Auth.editar');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteupReq $request, Cliente $cliente)
    {
        //
        $cliente->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'identificacion' => $request->identificacion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccionfiscal' => $request->direccionfiscal
        ]);
        $muestra = Auth::guard('client')->user()->idcliente;
        //return $muestra;
        return redirect()->route('editar_perfil_cliente', Auth::guard('client')->user()->idcliente)->with('status', '¡Datos Cliente Actualizados Correctamente!');

        //return $request;

    }
    public function updatepass(Request $request, Cliente $cliente)
    {
        $cliente->update([
            'password' => Hash::make($request->password)
        ]);


        //return $request;
        return redirect()->route('editar_perfil_cliente', Auth::guard('client')->user()->idcliente)->with('contrastatus', '¡Contraseña Actualizada Correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
