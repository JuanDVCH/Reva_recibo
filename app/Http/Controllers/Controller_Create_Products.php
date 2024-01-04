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
        // Recuperar los SKUs almacenados en la sesión
        $skus = session('skus', collect());

        // Obtener descripciones asociadas a SKUs
        $descripciones = Code_products::pluck('description')->toArray(); // Convertir a array

        // Almacenar las descripciones en la sesión para su uso posterior
        session(['descripciones' => $descripciones]);

        // Obtener recibos con estado 1
        $recibos = Model_Receipt::where('state', 1)->get();

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
                'orden_num' => 'required',
                'description' => 'required|exists:code_products,description', // Asegúrate de que el campo 'description' esté presente en las reglas de validación
            ]);

            // Crear instancia del modelo y asignar valores
            $producto = new Model_Products();
            $producto->sku = $request->sku;
            $producto->description = $request->description;
            $producto->unit_measurement = $request->unit_measurement;
            $producto->amount = $request->amount;
            $producto->gross_weight = $request->gross_weight;
            $producto->packaging_weight = $request->packaging_weight;
            $producto->net_weight = $request->net_weight;
            $producto->order_num = $request->orden_num;
            $producto->state = 1;

            // Intentar guardar el producto
            $producto->save();

            // Redirección después de guardar
            return redirect(route('recibo.index'));
        } catch (\Exception $e) {
            // Manejo del error
            dd($e->getMessage());
        }
    }


}
