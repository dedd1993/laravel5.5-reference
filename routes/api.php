<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('cliente', 'ClienteController');
Route::apiResource('cupon', 'CuponController');
Route::apiResource('factura', 'FacturaController');
Route::apiResource('pedido', 'PedidoController');
Route::apiResource('suscripcion', 'SuscripcionController');
Route::apiResource('pedido_detalle', 'PedidoDetalleController');
Route::apiResource('contacto-log', 'ContactoLogController');
Route::apiResource('mailing-suscripcion', 'MailingSuscripcionController');
Route::apiResource('reclamacion', 'ReclamacionController');
Route::apiResource('producto', 'ProductoController');
Route::apiResource('categoria', 'CategoriaController', ['parameters' => ['categoria' => 'categoria']]);
Route::apiResource('noticia', 'NoticiaController', ['parameters' => ['noticia' => 'noticia']]);
Route::apiResource('noticia_imagen', 'NoticiaImagenController');
Route::apiResource('evento', 'EventoController');
Route::apiResource('evento_imagen', 'EventoImagenController');
Route::apiResource('beneficio', 'BeneficioController');
Route::apiResource('beneficio_imagen', 'BeneficioImagenController');
Route::apiResource('payu_confirmacion', 'PayuConfirmacionController');

Route::post('pedido/giftcard', 'PedidoController@giftcard');
Route::put('pedido/{pedido}/confirm', 'PedidoController@confirm');
Route::put('pedido/{pedido}/cancel', 'PedidoController@cancel');

Route::get('giftcard', 'GiftcardController@index');
Route::get('giftcard/{giftcard}', 'GiftcardController@show');
Route::post('giftcard/validar', 'GiftcardController@validar');
Route::put('giftcard/canjear', 'GiftcardController@canjear');
Route::get('giftcard/pedido/{pedido}', 'GiftcardController@getByPedido');

Route::post('payu/confirmacion', 'PedidoController@payuConfirmation');
Route::get('payu_confirmacion/pedido/{pedido}', 'PayuConfirmacionController@getByPedido');

Route::get('/suscripcion/export/excel', 'SuscripcionController@export');

Route::get('noticia/filter/featured', 'NoticiaController@getFeatured');
Route::get('noticia/{noticia}/relacionadas', 'NoticiaController@getRelated');
Route::get('evento/{evento}/relacionadas', 'EventoController@getRelated');
Route::get('beneficio/{beneficio}/relacionadas', 'BeneficioController@getRelated');



Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::apiResource('plan', 'PlanController');
});

Route::get('env', function () {
    $env = [
        'MAIL_HOST' => env('MAIL_HOST'),
        'CRAFTIMES_EMAIL_CONTACTO' => env('CRAFTIMES_EMAIL_CONTACTO')
    ];
    dd($env) ;
});