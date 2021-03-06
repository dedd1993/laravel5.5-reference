<!DOCTYPE html>
<html>
<body>
    <div style="background:#fff; font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;">
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
            <tbody>
                <tr>
                    <td align="center" valign="top" style="padding:20px 0 20px 0">
                        <table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #131b4d">
                            <tbody>
                                <tr>
                                    <td bgcolor="#789f28" align="center" style="background:#789f28;text-align:center;padding:12px">
                                        <center>
                                            <img width="200" src="https://craftimes.com/assets/logo-white.png">
                                        </center>
                                    </td>
                                </tr>
                                <tr>
                                    @if ($pedido->detalles[0]['is_giftcard'])
                                        <td valign="top" style="padding:20px">
                                            <h1 style="font-size:22px;color:#131b4d;font-weight:normal;line-height:22px;margin:0 0 11px 0">Hola {{ $pedido->cliente['first_name'] }} {{ $pedido->cliente['last_name'] }},</h1>

                                            <p style="font-size:12px;line-height:16px;margin:0">&nbsp;</p>

                                            <p style="font-size:12px;line-height:16px;margin:0">
                                                <span style="font-size:14px;line-height:20px">
                                                    Gracias por tu compra,

                                                    @if (sizeof($pedido->detalles) === 1)
                                                        tu GIFT CARD para <b>{{ $pedido->detalles[0]['mailign_owner_name'] }}</b>
                                                        será entregado
                                                    @else
                                                        tus GIFT CARDS para
                                                        @foreach ($pedido->detalles as $indexKey => $detalle)
                                                            @if($loop->last)
                                                                y
                                                            @endif
                                                                <b>{{ $detalle['mailign_owner_name'] }}</b>
                                                        @endforeach
                                                        serán entregados
                                                    @endif

                                                    dentro de las siguientes 48 horas a la dirección de entrega que has asignado.
                                                </span>
                                            </p>
                                        </td>
                                    @else
                                        <td valign="top" style="padding:20px">
                                            <h1 style="font-size:22px;color:#131b4d;font-weight:normal;line-height:22px;margin:0 0 11px 0">Bienvenido {{ $pedido->cliente['first_name'] }} {{ $pedido->cliente['last_name'] }},</h1>

                                            <p style="font-size:12px;line-height:16px;margin:0">&nbsp;</p>

                                            <p style="font-size:12px;line-height:16px;margin:0">
                                                <span style="font-size:14px;line-height:20px">
                                                    A partir de hoy eres miembro de CRAFTIMES, club de cervezas artesanales. Tu
                                                    inscripción ha sido hecha satisfactoriamente y empezarás a recibir tu pack de
                                                    suscripción mensual.
                                                </span>
                                                <br><br>
                                                <span style="font-size:14px;line-height:20px">
                                                    La entrega se hará dentro de los primeros 10 días del mes siguiente, entre 9 AM y 6
                                                    PM en la dirección que has ingresado: {{ $envio['entrega_direccion'] }} - {{ $envio['entrega_distrito'] }}
                                                </span>
                                            </p>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td style="padding:0 20px">
                                        <h2 style="font-size:14px;line-height:18px;font-weight:normal;margin:0">
                                            Tu pedido #{{$pedido->id}} <small>({{ \Carbon\Carbon::parse($pedido->created_at)->format('l jS \\of F Y h:i:s A') }})</small>
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:20px">
                                        <table cellspacing="0" cellpadding="0" border="0" width="650">
                                            <thead>
                                            <tr>
                                                <th align="left" width="325" bgcolor="#6c9f28" style="font-size:12px;color:#fff;padding:7px 9px 8px 9px;line-height:1em">Información de facturación:</th>
                                                <th width="10"></th>
                                                <th align="left" width="325" bgcolor="#6c9f28" style="font-size:12px;color:#fff;padding:7px 9px 8px 9px;line-height:1em">Método de pago:</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                    @if ($pedido->factura)
                                                        {{ $pedido->factura['first_name'] }}
                                                        <br>

                                                        <a href="https://maps.google.com/?q={{ $pedido->factura['direccion'] }}, {{ $pedido->factura['distrito'] }}, Lima, Perú">
                                                            {{ $pedido->factura['direccion'] }}</a>
                                                        <br>

                                                        <a href="https://maps.google.com/?q={{ $pedido->factura['direccion'] }}, {{ $pedido->factura['distrito'] }}, Lima, Perú">
                                                            {{ $pedido->factura['distrito'] }}, Lima, </a>
                                                        <br>

                                                        <a href="https://maps.google.com/?q={{ $pedido->factura['direccion'] }}, {{ $pedido->factura['distrito'] }}, Lima, Perú">
                                                            Perú</a>
                                                        <br>

                                                        RUC: {{ $pedido->factura['razon_social'] }}
                                                    @else
                                                        <p><i>No solicitada</i></p>
                                                    @endif
                                                </td>

                                                <td>&nbsp;</td>

                                                <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                    @switch($pedido->tipo_de_pago)
                                                        @case("TRANSFERENCIA")
                                                            <p>Transferencia Bancaria - BCP</p>
                                                            <table>
                                                                <tbody>
                                                                <tr>
                                                                    <td>Si quieres que el pago de tu suscripción se haga de manera automática en tu cuenta, consúltanos a:
                                                                        <a href="mailto:contacto@craftimes.com" target="_blank">contacto@craftimes.com</a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        @break
                                                        @case("TARJETA")
                                                            <p>Tarjeta crédito/débito VISA/MASTER PayU</p>
                                                            @if (!$pedido->detalles[0]['is_giftcard'])
                                                                <table>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>Si quieres que el pago de tu suscripción se haga de manera automática en tu cuenta, consúltanos a:
                                                                            <a href="mailto:contacto@craftimes.com" target="_blank">contacto@craftimes.com</a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            @endif
                                                        @break
                                                        @case("CONTRA_ENTREGA")
                                                            <p><strong>Pago contra entrega (sólo para Lima metropolitana)</strong></p>
                                                        @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <h2 style="font-size:14px;line-height:18px;font-weight:normal;margin:15px 0 8px 0"></h2>
                                        <table cellspacing="0" cellpadding="0" border="0" width="650">
                                            <thead>
                                            <tr>
                                                <th align="left" width="325" bgcolor="#6c9f28" style="font-size:12px;color:#fff;padding:7px 9px 8px 9px;line-height:1em">Información de envío:</th>
                                                <th width="10"></th>
                                                <th align="left" width="325" bgcolor="#6c9f28" style="font-size:12px;color:#fff;padding:7px 9px 8px 9px;line-height:1em">Método de envío:</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea"><span class="im">
                                                    {{ $envio['remitente_nombres'] }}
                                                    <br>
                                                    <a href="https://maps.google.com/?q={{ $envio['entrega_direccion'] }}, {{ $envio['entrega_distrito'] }}, Lima, Perú">
                                                        {{ $envio['entrega_direccion'] }}</a>
                                                    <br>
                                                    <a href="https://maps.google.com/?q={{ $envio['entrega_direccion'] }}, {{ $envio['entrega_distrito'] }}, Lima, Perú">
                                                        {{ $envio['entrega_distrito'] }}, Lima, </a>
                                                    <br>
                                                    <a href="https://maps.google.com/?q={{ $envio['entrega_direccion'] }}, {{ $envio['entrega_distrito'] }}, Lima, Perú">
                                                        Perú</a>
                                                    <br>T: {{ $envio['remitente_telefono'] }} &nbsp;
                                                </td>
                                                <td>&nbsp;</td>
                                                <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                    Método de envío - Standard &nbsp;
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <br>


                                        <table cellspacing="0" cellpadding="0" border="0" width="650" style="border:1px solid #eaeaea">
                                            <thead>
                                            <tr>
                                                <th align="left" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Artículo</th>
                                                <th align="left" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Codigo de Artículo</th>
                                                <th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Cantidad</th>
                                                <th align="right" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Precio unitario</th>
                                                <th align="right" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Total</th>
                                            </tr>
                                            </thead>

                                            <tbody bgcolor="#F6F6F6">
                                            @foreach ($pedido->detalles as $detalle)
                                                <tr>
                                                    <td align="left" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc">
                                                        <strong style="font-size:11px">{{ $detalle->producto['nombre'] }}</strong>
                                                    </td>
                                                    <td align="left" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc">{{ $detalle->producto['codigo'] }}</td>
                                                    <td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc">{{ $detalle->cantidad }}</td>
                                                    <td align="right" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc">
                                                        <span class="m_322456910589396027m_768238685266715055price">S/{{ $detalle->precio_unitario }}</span>
                                                    </td>
                                                    <td align="right" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc">
                                                        <span class="m_322456910589396027m_768238685266715055price">S/{{ $detalle->total }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                            <tbody>
                                            <tr class="m_322456910589396027m_768238685266715055subtotal">
                                                <td colspan="4" align="right" style="padding:3px 9px">Subtotal</td>
                                                <td align="right" style="padding:3px 9px">
                                                    <span class="m_322456910589396027m_768238685266715055price">S/{{ $pedido->subtotal }}</span>
                                                </td>
                                            </tr>
                                            @if ($pedido->cupon_id)
                                                <tr class="m_322456910589396027m_768238685266715055subtotal">
                                                    <td colspan="4" align="right" style="padding:3px 9px">Descuento</td>
                                                    <td align="right" style="padding:3px 9px">
                                                        <span class="m_322456910589396027m_768238685266715055price">S/{{ $pedido->descuento }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="m_322456910589396027m_768238685266715055shipping">
                                                <td colspan="4" align="right" style="padding:3px 9px">Costo de envío </td>
                                                <td align="right" style="padding:3px 9px">
                                                    <span class="m_322456910589396027m_768238685266715055price">S/0</span>
                                                </td>
                                            </tr>
                                            <tr class="m_322456910589396027m_768238685266715055grand_total">
                                                <td colspan="4" align="right" style="padding:3px 9px">
                                                    <strong>Suma total</strong>
                                                </td>
                                                <td align="right" style="padding:3px 9px">
                                                    <strong>
                                                        <span class="m_322456910589396027m_768238685266715055price">S/{{ $pedido->subtotal - $pedido->descuento }}</span>
                                                    </strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <p style="font-size:12px;margin:0 0 10px 0"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding:20px; padding-top: 0">
                                        <p style="font-size:12px;line-height:16px;margin:0">
                                            <span style="font-size:14px;line-height:20px">Si tienes alguna duda respecto a su pedido, ponte en contacto con nosotros enviando un correo electrónico a
                                                <a href="mailto:contacto@craftimes.com" style="color:#789f28; font-weight: bold;" target="_blank">contacto@craftimes.com</a>, por el chat online o Whatsapp a
                                                <span class="m_322456910589396027m_768238685266715055nobr">(+51) 994 043 709</span>.
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding:20px; padding-top: 0">
                                        <p style="font-size:12px;line-height:16px;margin:0">
                                            <span style="font-size:14px;line-height:20px">SALUD!!!
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#789f28" align="center" style="background:#789f28;text-align:center;padding:12px">
                                        <center>
                                            <p style="font-size:12px;color:#fff;margin:0">
                                                <strong>CRAFTIMES.COM</strong>
                                            </p>
                                        </center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
