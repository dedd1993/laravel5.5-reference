<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cliente = Cliente::orderByDesc("id")->get();
        return response($cliente, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Cliente();
        $cliente->first_name = $request->first_name;
        $cliente->last_name = $request->last_name;
        $cliente->email = $request->email;
        $cliente->address = $request->address;
        $cliente->address_city = $request->address_city;
        $cliente->country_code = $request->country_code;
        $cliente->phone_number = $request->phone_number;
        $cliente->save();

        return response($cliente, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        return response($cliente, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $cliente->first_name = $request->first_name;
        $cliente->last_name = $request->last_name;
        $cliente->address = $request->address;
        $cliente->address_city = $request->address_city;
        $cliente->country_code = $request->country_code;
        $cliente->phone_number = $request->phone_number;
        $cliente->save();
        return response($cliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response([
            'id'=> $cliente->id,
            'deleted'=> true,
            'message' => "Se eliminó el plan con ID {$cliente->id} con exitosamente."
        ], 200);
    }
}
