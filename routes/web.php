<?php
use App\Http\Controllers\ControllerEtiqueta;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller_Format_Receipt;
use App\Http\Controllers\Controller_Create_Products;
use App\Http\Controllers\ControllerPulpo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.Login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas para el recurso "Recibo"
Route::resource('Recibo', Controller_Format_Receipt::class)->names('recibo');

// Rutas para el recurso "Productos"
Route::resource('Productos', Controller_Create_Products::class)->names('productos');

// Rutas para el recurso "Etiquetas"
Route::resource('Etiquetas', ControllerEtiqueta::class)->names('etiqueta');

// Rutas para impresión
Route::get('/etiquetas/imprimir/{id_tag}', [ControllerEtiqueta::class, 'imprimir'])->name('etiquetas.imprimir');


// Rutas para el recurso "Pulpo"
Route::resource('Pulpo', ControllerPulpo::class)->names('pulpo');

Route::get('/productos/form/{order_num}', 'Controller_Create_Products@show')->name('productos.form');
Route::get('/pulpo/form/{order_num}', 'ControllerPulpo@showPulpo')->name('pulpo.form');
Route::get('pulpo/exportar/{order_num}/{sku}/{supplier_code}', 'ControllerPulpo@show')->name('pulpo.exportar');



