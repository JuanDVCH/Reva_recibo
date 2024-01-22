<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Code_products;
use App\Models\Model_Products;
use App\Models\Model_Receipt;
use Illuminate\Http\Request;

class Controller_Create_Products extends Controller
{
    public function index(Request $request)
    {
        $order_number = $request->input('order_num', null);

        $productos = $order_number
            ? Model_Products::where('state', 1)
                ->whereHas('recibo', function ($query) use ($order_number) {
                    $query->where('order_num', $order_number);
                })
                ->with('code_products')
                ->get()
            : collect();

        $recibos = Model_Receipt::where('state', 1)->get();
        $skus = Code_products::pluck('sku');
        $descripciones = Code_products::pluck('description');

        // Almacena los SKUs y descripciones en la sesión
        session(['skus' => $skus]);
        session(['descriptions' => $descripciones]);

        // Pasa $skus y $descripciones a la vista
        return view('Productos.index', compact('productos', 'order_number', 'recibos', 'skus', 'descripciones'));
    }

    public function create()
    {
        // Recuperar los SKUs almacenados en la sesión y ordenar alfabéticamente
        $skus = session('skus', collect())->sort()->values();

        // Obtener descripciones asociadas a SKUs y ordenar alfabéticamente
        $descripciones = Code_products::pluck('description')->sort()->values()->toArray();

        // Obtener recibos con estado 1 y ordenarlos por número de recibo
        $recibos = Model_Receipt::where('state', 1)->orderBy('order_num')->get();

        // Almacenar las descripciones en la sesión para su uso posterior
        session(['descripciones' => $descripciones]);

        // Configurar la vista con los datos necesarios antes de la condición
        return view('Productos.create', compact('recibos', 'skus', 'descripciones'));
    }


    public function obtenerSkus(Request $request)
    {
        $orderNum = $request->input('orderNum');

        // Obtén los SKUs asociados al número de recibo
        $skus = Model_Products::where('order_num', $orderNum)->distinct('sku')->pluck('sku');

        return response()->json($skus);
    }

    public function obtenerDescripcionPorSku(Request $request)
    {
        try {
            $sku = $request->input('sku');
            $descripcion = Code_products::where('sku', $sku)->value('description');

            if ($descripcion === null) {
                throw new \Exception("No se encontró descripción para el SKU: $sku");
            }

            return response()->json(['descripcion' => $descripcion]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validación de datos
            $request->validate([
                'sku' => 'required|exists:code_products,sku',
                'unit_measurement' => 'required',
                'amount' => 'required|numeric',
                'gross_weight' => 'required|numeric',
                'packaging_weight' => 'required|numeric',
                'net_weight' => 'required|numeric',
                'orden_num' => 'required', // Cambiado de 'order_num'
                'description' => 'required|exists:code_products,description',
                'notes' => 'nullable|string',
                'criterium' => 'nullable|string',
            ]);

            // Obtener información de recibo (delivery_date y code_customer) asociada a orden_num
            $reciboInfo = Model_Receipt::where('order_num', $request->orden_num)
                ->select('delivery_date', 'code_customer')
                ->first();

            // Verificar si se encontró información del recibo
            if (!$reciboInfo) {
                // Manejar el caso en el que no se encuentra la información del recibo
                return redirect()->back()->with('error', 'No se encontró información del recibo.');
            }

            // Crear instancia del modelo y asignar valores
            $producto = new Model_Products();
            $producto->sku = $request->sku;
            $producto->description = $request->description;
            $producto->unit_measurement = $request->unit_measurement;
            $producto->amount = $request->amount;
            $producto->gross_weight = $request->gross_weight;
            $producto->packaging_weight = $request->packaging_weight;
            $producto->net_weight = $request->net_weight;
            $producto->order_num = $request->orden_num; // Cambiado de 'order_num'
            $producto->notes = $request->notes;
            $producto->criterium = $request->criterium;
            $producto->code_customer = $reciboInfo->code_customer;
            $producto->state = 1;

            // Intentar guardar el producto
            $producto->save();

            // Redirección después de guardar
            return redirect(route('recibo.index'))->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            // Manejo del error
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function obtenerInfoRecibo(Request $request)
    {
        $orderNum = $request->input('order_num');

        // Obtener información de recibo según el número de recibo
        $recibo = Model_Receipt::where('order_num', $orderNum)->first();

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
            ]);
        }
    }
}
