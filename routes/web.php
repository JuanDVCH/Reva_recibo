<?php
// Importación de controladores y clases necesarias
use App\Http\Controllers\C_Tags;
use App\Http\Controllers\C_Receipts;
use App\Http\Controllers\C_Products;
use App\Http\Controllers\C_profile;
use App\Http\Controllers\C_Users;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Auth;

// Rutas de autenticación proporcionadas por Laravel
Auth::routes();

// Ruta predeterminada para usuarios no autenticados
Route::get('/', function () {
    // Redirigir a /home si el usuario está autenticado, de lo contrario, mostrar la vista de inicio de sesión
    return Auth::check() ? redirect('/home') : view('auth.Login');
});

// Rutas que requieren autenticación
Route::middleware(['web', 'auth'])->group(function () {
    // Ruta para mostrar la vista de inicio después de iniciar sesión
    Route::get('/home', [App\Http\Controllers\C_home::class, 'index'])->name('home');

    // Ruta para cerrar sesión
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


    // Rutas agrupadas por recursos
    Route::group(['prefix' => 'recibo'], function () {
        // Rutas relacionadas con los recibos
        Route::resource('/', C_Receipts::class)->names('recibo');
        Route::get('/obtener-codigos-cliente/{id}', [C_Receipts::class, 'obtenerCodigosCliente']);
        Route::get('/recibos/filtrar', 'C_Receipts@filtrar')->name('recibos.filtrar');
        Route::put('recibo/update', [C_Receipts::class, 'update'])->name('recibo.update');
    });

    // Ruta para gestionar usuarios
    Route::group(['prefix' => 'users', 'middleware' => 'Administrador'], function () {
        Route::resource('users', C_Users::class);
    });



    Route::group(['prefix' => 'profile', 'middleware' => 'Administrador'], function () {
        // Rutas para editar y actualizar el perfil del usuario
        Route::get('profile/edit', [C_profile::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [C_profile::class, 'update'])->name('profile.update');
    });



    // Rutas agrupadas para productos
    Route::group(['prefix' => 'productos'], function () {
        // Rutas relacionadas con la gestión de productos
        Route::resource('/', C_Products::class)->names('productos');
        Route::post('/obtener-info-recibo', [C_Products::class, 'obtenerInfoRecibo'])->name('obtenerInfoRecibo');
        Route::get('/obtener-productos-por-orden/{orderNum}', [C_Products::class, 'obtenerProductosPorOrden'])
            ->name('obtener.productos.por.orden');
        Route::post('/obtener-sku-por-descripcion', [C_Products::class, 'obtenerSkuPorDescripcion'])->name('obtenerSkuPorDescripcion');
    });

    // Rutas agrupadas para etiquetas
    Route::group(['prefix' => 'etiquetas'], function () {
        // Rutas relacionadas con la gestión de etiquetas
        Route::resource('/', C_Tags::class)->names('etiqueta');
        Route::get('/obtener-skus-y-customer', [C_Tags::class, 'obtenerSkusYCustomer'])->name('etiqueta.obtener-skus-y-customer');
        Route::post('/obtener-descripcion-por-sku', [C_Tags::class, 'obtenerDescripcionPorSku'])->name('etiqueta.obtener-descripcion-por-sku');
        Route::post('/obtener-barcode-por-sku', [C_Tags::class, 'obtenerBarcodePorSku'])->name('etiqueta.obtener-barcode-por-sku');
        Route::get('/{id_tag}/imprimir', [C_Tags::class, 'imprimir'])->name('etiquetas.imprimir');
        Route::post('/obtener-info-reciboetiquetas', [C_Tags::class, 'obtenerInfoReciboetiquetas'])->name('obtenerInfoReciboetiquetas');
    });

    // Ruta para asignar el rol de administrador
    Route::get('/assign-admin-role', [RolePermissionController::class, 'assignAdminRole']);


});
