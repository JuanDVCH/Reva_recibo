<?php

namespace App\Http\Controllers;

use App\Models\M_Segregation\M_S_Product_for_segregation;
use Illuminate\Support\Facades\Session;
use App\Models\M_Products;
use App\Models\M_codeProducts;
use App\Models\M_Receipts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class C_Products extends Controller
{
    public function index(Request $request)
    {
        try {
            // Obtener el número de pedido de la solicitud
            $orderNumber = $request->input('order_num', null);
    
            // Obtener productos basados en el número de pedido (si se proporciona)
            $productos = $orderNumber
                ? M_Products::where('order_num', $orderNumber)->where('state', 1)->with('M_codeProducts')->get()
                : collect();
    
            // Obtener todos los recibos con estado 1
            $recibos = M_Receipts::where('state', 1)->get();
    
            // Obtener todos los SKUs y descripciones disponibles
            $skus = M_codeProducts::pluck('sku');
            $descripciones = M_codeProducts::pluck('description');
    
            // Almacenar SKUs y descripciones en la sesión para su uso posterior
            session(['skus' => $skus, 'descripciones' => $descripciones]);
    
            // Pasar datos a la vista
            return view('Receipts.Productos.index', compact('productos', 'orderNumber', 'recibos', 'skus', 'descripciones'));
        } catch (\Exception $e) {
            // Manejar excepciones
            return back()->withErrors(['error' => 'Ha ocurrido un error.']);
        }
    }

    public function indexfin(Request $request)
    {
        try {
            // Obtener el número de pedido de la solicitud
            $orderNumber = $request->input('order_num', null);
    
            // Obtener productos basados en el número de pedido (si se proporciona)
            $productos = $orderNumber
                ? M_Products::where('order_num', $orderNumber)->where('state', 1)->with('M_codeProducts')->get()
                : collect();
    
            // Obtener todos los recibos con estado 1
            $recibos = M_Receipts::where('state', 1)->get();
    
            // Obtener todos los SKUs y descripciones disponibles
            $skus = M_codeProducts::pluck('sku');
            $descripciones = M_codeProducts::pluck('description');
    
            // Almacenar SKUs y descripciones en la sesión para su uso posterior
            session(['skus' => $skus, 'descripciones' => $descripciones]);
    
            // Pasar datos a la vista
            return view('Receipts.Productos.indexfin', compact('productos', 'orderNumber', 'recibos', 'skus', 'descripciones'));
        } catch (\Exception $e) {
            // Manejar excepciones
            return back()->withErrors(['error' => 'Ha ocurrido un error.']);
        }
    }
    
    

    public function create()
    {
        // Recuperar los SKUs almacenados en la sesión y ordenar alfabéticamente
        $skus = session('skus', collect())->sort()->values();

        // Obtener descripciones asociadas a SKUs y ordenar alfabéticamente
        $descripciones = M_codeProducts::pluck('description')->sort()->values()->toArray();

        // Obtener recibos con estado 1 y ordenarlos por número de recibo
        $recibos = M_Receipts::where('state', 1)->orderBy('order_num')->get();

        // Almacenar las descripciones en la sesión para su uso posterior
        session(['descripciones' => $descripciones]);

        // Configurar la vista con los datos necesarios antes de la condición
        return view('Receipts.Productos.create', compact('recibos', 'skus', 'descripciones'));
    }

    public function obtenerSkus(Request $request)
    {
        $orderNum = $request->input('orderNum');

        // Obtén los SKUs asociados al número de recibo
        $skus = M_Products::where('order_num', $orderNum)->distinct('sku')->pluck('sku');

        return response()->json($skus);
    }

    public function obtenerSkuPorDescripcion(Request $request)
    {
        $descripcion = $request->input('descripcion');

        // Realizar la consulta a la base de datos para obtener el SKU
        $codeProduct = M_codeProducts::where('description', $descripcion)->first();

        if ($codeProduct) {
            $sku = $codeProduct->sku;
            return response()->json(['sku' => $sku]);
        } else {
            return response()->json(['sku' => null]);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validación de datos
            $request->validate([
                // ... (tus reglas de validación)
            ], [
                // ... (tus mensajes de error personalizados)
            ]);

            // Crear instancia del modelo y asignar valores
            $producto = new M_Products();
            $producto->sku = $request->sku;
            $producto->description = $request->description;
            $producto->unit_measurement = $request->unit_measurement;
            $producto->amount = $request->amount;
            $producto->gross_weight = $request->gross_weight;
            $producto->packaging_weight = $request->packaging_weight;
            $producto->net_weight = $request->net_weight;
            $producto->order_num = $request->orden_num;
            $producto->delivery_date = $request->delivery_date;
            $producto->criterium = $request->criterium;
            $producto->notes = $request->notes;
            $producto->code_customer = $request->code_customer;

            // Asignar el valor '1' al campo 'state'
            $producto->state = 1;

            // Intentar guardar el producto
            $producto->save();
            
            $producto = new M_S_Product_for_segregation();
            $producto->sku = $request->sku;
            $producto->description = $request->description;
            $producto->net_weight = $request->net_weight;
            $producto->order_num = $request->orden_num;

            // Asignar el valor '1' al campo 'state'
            $producto->state = 1;

            // Intentar guardar el producto
            $producto->save();
            
            // Redirección después de guardar
            return redirect(route('Receipts.create.index'));
        } catch (\Exception $e) {
            // Manejo del error
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function obtenerInfoRecibo(Request $request)
    {
        $orderNum = $request->input('order_num');

        // Obtener información de recibo según el número de recibo
        $recibo = M_Receipts::where('order_num', $orderNum)->first();

        if ($recibo) {
            return response()->json([
                'success' => true,
                'data' => [
                    'delivery_date' => $recibo->delivery_date,
                    'code_customer' => $recibo->code_customer,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
            ], 404);
        }
    }
    public function obtenerProductosPorOrden($orderNum) {
        $productos = M_Products::where('order_num', $orderNum)->get();
        return response()->json(['productos' => $productos]);
    }

}
