<?php

namespace App\Http\Controllers\C_Segregation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_Segregation\M_S_Product_for_segregation;
use App\Models\M_Receipts;
use App\Models\M_codeProducts;
use Illuminate\Support\Facades\Session;

class C_S_Products extends Controller
{

    public function product_for_segregation(Request $request)
    {
        try {
            // Obtener el número de pedido de la solicitud
            $orderNumber = $request->input('order_num', null);
    
            // Obtener productos basados en el número de pedido (si se proporciona)
            $productos = $orderNumber
                ? M_S_Product_for_segregation::where('order_num', $orderNumber)->where('state', 1)->with('M_codeProducts')->get()
                : collect();
    
            // Obtener todos los recibos con estado 1
            $recibos = M_Receipts::where('state', 1)->get();
    
            // Obtener todos los SKUs y descripciones disponibles
            $skus = M_codeProducts::pluck('sku');
            $descripciones = M_codeProducts::pluck('description');
    
            // Almacenar SKUs y descripciones en la sesión para su uso posterior
            Session::put('skus', $skus);
            Session::put('descripciones', $descripciones);
    
            // Pasar datos a la vista
            return view('Segregation.s_product.product_for_segregation', compact('productos', 'orderNumber', 'recibos', 'skus', 'descripciones'));
        } catch (\Exception $e) {
            // Manejar excepciones
            return back()->withErrors(['error' => 'Ha ocurrido un error.']);
        }
    }
}
