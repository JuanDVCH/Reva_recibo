<?php
use App\Http\Controllers\ControllerEtiqueta;
use App\Http\Controllers\Controller_Format_Receipt;
use App\Http\Controllers\Controller_Create_Products;
use App\Http\Controllers\ControllerPulpo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rutas que requieren autenticación
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    // Otras rutas autenticadas aquí si es necesario
});

// Rutas de autenticación proporcionadas por Laravel
Auth::routes();

// Ruta predeterminada para usuarios no autenticados
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home'); // Redirige a /home si el usuario ya está autenticado
    } else {
        return view('auth.Login');
    }
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas para el recurso "Recibo"
Route::resource('Recibo', Controller_Format_Receipt::class)->names('recibo');
Route::get('/obtener-codigos-cliente/{id}', [Controller_Format_Receipt::class, 'obtenerCodigosCliente']);


// Rutas para el recurso "Productos"
Route::resource('Productos', Controller_Create_Products::class)->names('productos');
Route::post('/obtener-descripcion-por-sku', [Controller_Create_Products::class, 'obtenerDescripcionPorSku'])->name('obtenerDescripcionPorSku');


// Rutas para el recurso "Etiquetas"
Route::resource('Etiquetas', ControllerEtiqueta::class)->names('etiqueta');
Route::get('/etiqueta/obtener-skus-y-customer', [ControllerEtiqueta::class, 'obtenerSkusYCustomer'])->name('etiqueta.obtener-skus-y-customer');
Route::post('/etiqueta/obtener-descripcion-por-sku', [ControllerEtiqueta::class, 'obtenerDescripcionPorSku'])->name('etiqueta.obtener-descripcion-por-sku');
Route::post('/etiqueta/obtener-barcode-por-sku', [ControllerEtiqueta::class, 'obtenerBarcodePorSku'])->name('etiqueta.obtener-barcode-por-sku');
Route::get('/etiquetas/imprimir/{id_tag}', [ControllerEtiqueta::class, 'imprimir'])->name('etiquetas.imprimir');


// Rutas para el recurso "Pulpo"
Route::resource('Pulpo', ControllerPulpo::class)->names('pulpo');
Route::get('/obtener-skus', [ControllerPulpo::class, 'obtenerSkus'])->name('pulpo.obtener-skus');
Route::get('/pulpo/obtener-peso-neto', [ControllerPulpo::class, 'obtenerPesoNeto'])->name('pulpo.obtener-peso-neto');

Route::post('/pulpo/filtrar', 'ControllerPulpo@filtrar')->name('pulpo.filtrar');

Route::get('/productos/form/{order_num}', 'Controller_Create_Products@show')->name('productos.form');
Route::get('/pulpo/form/{order_num}', 'ControllerPulpo@showPulpo')->name('pulpo.form');
Route::get('pulpo/exportar/{order_num}/{sku}/{supplier_code}', 'ControllerPulpo@show')->name('pulpo.exportar');



