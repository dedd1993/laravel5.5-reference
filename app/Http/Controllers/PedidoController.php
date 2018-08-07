<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Pedido;
use App\Cliente;
use App\Producto;
use App\PedidoDetalle;
use App\Giftcard;
use App\Factura;
use App\Suscripcion;
use App\Mail\PedidoNuevoMailing;
use App\Mail\GiftcardMailing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Log;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'cupon', 'factura', 'detalles'])
            ->orderByDesc("id")
            ->get();
        return response($pedidos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->tipo_de_pago === 'TARJETA')
            return response(['error' => "Pago por tarjeta crédito/débito no disponible"], 409);

        $pedido = DB::transaction(function () use ($request) {
            $cliente = Cliente::where('email', $request->cliente['email'])->first();

            if (!$cliente) {
                $cliente = new Cliente();
                $cliente->card_number = null;
                $cliente->first_name = $request->cliente['first_name'];
                $cliente->last_name = $request->cliente['last_name'];
                $cliente->email = $request->cliente['email'];
                $cliente->address = $request->cliente['address'];
                $cliente->address_city = $request->cliente['address_city'];
                $cliente->country_code = $request->cliente['country_code'];
                $cliente->phone_number = $request->cliente['phone_number'];
                $cliente->save();
            }

            if ($request->factura) {
                $factura = new Factura();
                $factura->ruc = $request->factura['ruc'];
                $factura->razon_social = $request->factura['razon_social'];
                $factura->direccion = $request->factura['direccion'];
                $factura->distrito = $request->factura['distrito'];
                $factura->referencia = $request->factura['referencia'];
                $factura->save();
            }

            $pedido = new Pedido();
            $pedido->tipo_de_pago = $request->tipo_de_pago;
            $pedido->estado = 'PENDIENTE';
            $pedido->precio = 0;
            $pedido->cliente_id = $cliente->id;
            $pedido->cupon_id = $request->cupon_id;
            $pedido->factura_id = $request->factura ? $factura->id : null;
            foreach ($request->pedido_detalle as $pd) {
                $producto = Producto::find($pd['producto_id']);
                $pedido->precio = $pedido->precio + ($producto['precio'] * $pd['cantidad']);
            }
            $pedido->save();

            foreach ($request->pedido_detalle as $pd) {
                $producto = Producto::find($pd['producto_id']);

                $pedido_detalle = new PedidoDetalle();
                $pedido_detalle->precio_unitario = $producto->precio;
                $pedido_detalle->cantidad = $pd['cantidad'];
                $pedido_detalle->total = $pd['cantidad'] * $producto->precio;
                $pedido_detalle->pedido_id = $pedido->id;
                $pedido_detalle->producto_id = $producto->id;
                $pedido_detalle->save();

                if ($pd['tipo'] === "GIFTCARD") {
                    // GIFTCARD
                    $giftcard = new Giftcard();
                    $giftcard->estado = 'DISPONIBLE';
                    $giftcard->codigo = $this->random(10);
                    $giftcard->mailing_owner_address = isset($pd['mailing_owner_address']) ? $pd['mailing_owner_address'] : null;
                    $giftcard->mailign_owner_name = isset($pd['mailign_owner_name']) ? $pd['mailign_owner_name'] : null;
                    $giftcard->remitente_nombres = $request->envio['remitente_nombres'];
                    $giftcard->remitente_email = $request->envio['remitente_email'];
                    $giftcard->remitente_telefono = $request->envio['remitente_telefono'];
                    $giftcard->entrega_direccion = $request->envio['direccion'];
                    $giftcard->entrega_distrito = $request->envio['distrito'];
                    $giftcard->entrega_referencia = $request->envio['referencia'];
                    $giftcard->pedido_detalle_id = $pedido_detalle->id;
                    $giftcard->save();

                    if ($giftcard->mailing_owner_address)
                        Mail::send(new GiftcardMailing($giftcard));

                } else {
                    // SUSCRIPCION
                    $suscripcion = new Suscripcion();
                    $suscripcion->fecha_de_inicio = date("Y-m-d H:i:s");
                    $suscripcion->nombres = $request->envio['remitente_nombres'];
                    $suscripcion->email = $request->envio['remitente_email'];
                    $suscripcion->celular = $request->envio['remitente_telefono'];
                    $suscripcion->direccion = $request->envio['direccion'];
                    $suscripcion->distrito = $request->envio['distrito'];
                    $suscripcion->referencia = $request->envio['referencia'];
                    $suscripcion->pedido_detalle_id = $pedido_detalle->id;
                    $suscripcion->save();
                }
            }

            return $pedido;
        });

        $pedidoForMailing = Pedido::with([
            'cliente',
            'factura',
            'detalles'
        ])->find($pedido->id);

//        return view('email.pedidonuevo')->with(['pedido' => $pedidoForMailing, 'envio' => $request->envio]);

        Mail::send(new PedidoNuevoMailing($pedidoForMailing, $request->envio));

        return response($pedidoForMailing, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::with([
            'cliente',
            'cupon',
            'factura',
            'detalles'
        ])->find($id);

        return response($pedido, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, Pedido $pedido)
    {
        if ($pedido->estado !== 'PENDIENTE')
            return response(['error' => "El pedido ya ha sido '{$pedido['estado']}'"], 409);

        $pedido_actualizado = DB::transaction(function () use ($pedido) {
//            PedidoDetalle::where('pedido_id', $pedido->id)
//                ->update([
//                    'fecha_de_inicio' => date("Y-m-d H:i:s")
//                ]);

            $pedido->estado = 'CONFIRMADA';
            $pedido->save();

            return $pedido;
        });

        return response([
            'message' => "Se ha actualizado el estado del pedido a '{$pedido_actualizado['estado']}'",
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, Pedido $pedido)
    {
        if ($pedido->estado !== 'PENDIENTE')
            return response(['error' => "El pedido ya ha sido '{$pedido['estado']}'"], 409);

        $pedido->estado = 'CANCELADA';
        $pedido->save();
        return response($pedido, 200);
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function random($length = 16)
    {
        if ( ! function_exists('openssl_random_pseudo_bytes'))
        {
            throw new RuntimeException('OpenSSL extension is required.');
        }

        $bytes = openssl_random_pseudo_bytes($length * 2);

        if ($bytes === false)
        {
            throw new RuntimeException('Unable to generate random string.');
        }

        return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
    }

    public function payuConfirmation(Request $request)
    {
        Log::info('New post request from PayU');
        $data = $_POST;
        Log::info($data);
        return response(null, 200);
    }
}
