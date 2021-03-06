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
                                    <td valign="top" style="padding:20px">
                                        <h1 style="font-size:22px;color:#131b4d;font-weight:normal;line-height:22px;margin:0 0 11px 0">!Hola {{ $pedido->cliente['first_name'] }} {{ $pedido->cliente['last_name'] }}!</h1>

                                        <p style="font-size:12px;line-height:16px;margin:0">&nbsp;</p>

                                        <p style="font-size:12px;line-height:16px;margin:0">
                                            <span style="font-size:14px;line-height:20px">
                                                <b>{{ $giftcard->mailign_owner_name }}</b>  ha activado su Gift Card hoy <small>({{ \Carbon\Carbon::parse($pedido->created_at)->format('l jS \\of F Y h:i:s A') }})</small>
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding:20px; padding-top: 0">
                                        <p style="font-size:12px;line-height:16px;margin:0">
                                            <span style="font-size:14px;line-height:20px">¡Gracias!
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
