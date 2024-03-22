<?php

namespace App\Http\Controllers\C_Segregation;
use App\Models\M_Segregation\M_S_Product_for_segregation;
use App\Models\M_codeProducts;
use App\Models\M_Receipts;
use App\Models\M_Segregation\M_S_Receipts;
use App\Models\M_Suppliers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class C_S_Receipts extends Controller
{
    public function index(Request $request)
    {
        $query = M_Receipts::where('state', '0');

        // Verificar si hay un filtro de cliente
        if ($request->filled('cliente')) {
            $query->where('customer', 'LIKE', '%' . $request->input('cliente') . '%');
        }

        // Obtener todos los recibos 
        $recibos = $query->get();

        // Obtener el total de recibos
        $totalRecibos = $recibos->count();

        // Obtener todos los proveedores
        $suppliers = M_Suppliers::all();

        return view('Segregation.S_receipt.S_index', compact('recibos', 'suppliers', 'totalRecibos'));
    }

    public function product_for_segregation(Request $request)
    {
        try {
            // Obtener el número de pedido de la solicitud
            $orderNumber = $request->input('order_num', null);
    
            // Obtener productos basados en el número de pedido si se proporciona, de lo contrario obtener todos los productos disponibles
            $productos = $orderNumber
                ? M_S_Product_for_segregation::where('order_num', $orderNumber)->where('state', 1)->with('M_codeProducts')->get()
                : M_S_Product_for_segregation::where('state', 1)->with('M_codeProducts')->get();
    
            // Obtener todos los recibos con estado 1
            $recibos = M_Receipts::where('state', 1)->get();
    
            // Obtener todos los SKUs y descripciones disponibles
            $skus = M_codeProducts::pluck('sku');
            $descripciones = M_codeProducts::pluck('description');
            
    
            // Almacenar SKUs y descripciones en la sesión para su uso posterior
            session::put('skus', $skus);
            Session::put('descripciones', $descripciones);
    
            // Pasar datos a la vista
            return view('Segregation.S_receipt.product_for_segregation', compact('productos', 'orderNumber', 'recibos', 'skus', 'descripciones'));
        } catch (\Exception $e) {
            // Manejar excepciones
            return back()->withErrors(['error' => 'Ha ocurrido un error.']);
        }
    }
    

    public function Num_format(Request $request)
    {
        $query = M_S_Receipts::where('state', '1');

        // Verificar si hay un filtro de cliente
        if ($request->filled('cliente')) {
            $query->where('customer', 'LIKE', '%' . $request->input('cliente') . '%');
        }

        // Obtener todos los recibos 
        $recibos = $query->get();

        // Obtener el total de recibos
        $totalRecibos = $recibos->count();

        // Obtener todos los proveedores
        $suppliers = M_Suppliers::all();

        return view('Segregation.S_receipt.Num_format', compact('recibos', 'suppliers', 'totalRecibos'));
    }

}


