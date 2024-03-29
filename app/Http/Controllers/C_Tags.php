<?php

namespace App\Http\Controllers;

use App\Models\M_Tags;
use Illuminate\Http\Request;
use App\Models\M_Receipts;
use App\Models\M_codeProducts;
use App\Models\M_Products;
use PDF;
use Illuminate\Support\Facades\Log; // Add this line

//use Imagick;

class C_Tags extends Controller
{
    public function index()
    {
        // Usar alias más descriptivos para mejorar la legibilidad
        $etiquetas = M_Tags::select('rec.order_num as recibo_numero', 'prod.sku as sku_producto', 'tags.*')
            ->join('receipts as rec', 'tags.order_num', '=', 'rec.order_num')
            ->join('product as prod', 'tags.sku', '=', 'prod.sku')
            ->where('tags.state', 1)
            ->distinct()
            ->orderBy('tags.delivery_date', 'desc')
            ->get(); // Agregar el método get() para ejecutar la consulta y obtener los resultados

        // Obtener la lista de recibos y productos solo si es necesario
        $recibos = M_Receipts::where('state', 1)->get();
        $productos = M_Products::where('state', 1)->get();

        return view('Receipts.etiquetas.index', compact('etiquetas', 'productos', 'recibos'));
    }


    public function create()
    {
        $recibos = M_Receipts::where('state', 1)->get();
        $productos = M_Products::where('state', 1)->get();
        return view('Receipts.etiquetas.create', compact('recibos', 'productos'));
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'order_num' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'delivery_date' => 'required|date', // Asegura que sea una fecha válida
            'customer' => 'required',
            'amount' => 'required|numeric', // Asegura que sea un número
            'weight' => 'required|numeric',
            'type' => 'required|in:rigido_P,rigido_G,flexible_P,flexible_G,No_aplica', // Asegura que el valor esté en la lista dada
            'content' => 'required|in:aderezos,limpieza,No_aplica',
            'product_status' => 'required|in:sucio,limpio,No_aplica',
            'color' => 'required|in:colores,neutro,No_aplica',
            'barcode' => 'required',
        ]);

        try {
            // Obtener información de recibo (delivery_date y customer) asociada a orden_num
            $reciboInfo = M_Receipts::where('order_num', $request->order_num)
                ->select('delivery_date', 'customer')
                ->first();

            // Verificar si se encontró información del recibo
            if (!$reciboInfo) {
                // Manejar el caso en el que no se encuentra la información del recibo
                return redirect()->back()->with('error', 'No se encontró información del recibo.');
            }

            // Crear una nueva instancia del modelo Etiqueta y asignar valores
            $etiqueta = new M_Tags();
            $etiqueta->order_num = $request->order_num;
            $etiqueta->sku = $request->sku;
            $etiqueta->description = $request->description;
            $etiqueta->delivery_date = $request->delivery_date;
            $etiqueta->customer = $request->customer;
            $etiqueta->amount = $request->amount;
            $etiqueta->weight = $request->weight;
            $etiqueta->type = $request->type;
            $etiqueta->content = $request->content;
            $etiqueta->product_status = $request->product_status;
            $etiqueta->color = $request->color;
            $etiqueta->barcode = $request->barcode;
            $etiqueta->state = 1; // Suponiendo que 'state' es el nombre correcto del atributo
            $etiqueta->save();

            return redirect()->route('Receipts.etiqueta.index')->with('success', 'Recibo creado exitosamente.');
        } catch (\Exception $e) {
            // Log del error
            Log::error($e->getMessage());

            // Redirige de nuevo con un mensaje de error
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al intentar guardar el recibo.']);
        }
    }




    public function show(string $order_num)
    {
        $etiqueta = M_Tags::where('order_num', $order_num)->first();

        return view('Receipts.etiquetas.show', compact('etiqueta'));
    }

    public function imprimir($id_tag)
    {
        $etiqueta = M_Tags::find($id_tag);

        // Generar el PDF con la librería PDF de Laravel
        $pdf = PDF::loadView('Receipts.etiquetas.imprimir', compact('etiqueta'));

        // Descargar el PDF directamente
        return $pdf->stream('Receipts.etiqueta.pdf');
    }


    public function obtenerSkusYCustomer(Request $request)
    {
        $orderNum = $request->input('orderNum');

        // Obtén los SKUs asociados al número de recibo
        $skus = M_Products::where('order_num', $orderNum)->distinct()->pluck('sku');

        // Obtén los clientes asociados al número de recibo
        $customers = M_Receipts::where('order_num', $orderNum)->distinct()->pluck('customer');

        return response()->json([
            'skus' => $skus,
            'customers' => $customers,
        ]);
    }


    public function obtenerDescripcionPorSku(Request $request)
    {
        try {
            $sku = $request->input('sku');
            $descripcion = M_codeProducts::where('sku', $sku)->value('description');

            if ($descripcion === null) {
                throw new \Exception("No se encontró descripción para el SKU: $sku");
            }

            return response()->json(['descripcion' => $descripcion]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function obtenerBarcodePorSku(Request $request)
    {
        try {
            $sku = $request->input('sku');
            $barcode = M_codeProducts::where('sku', $sku)->value('barcode');

            if ($barcode === null) {
                throw new \Exception("No se encontró código de barras para el SKU: $sku");
            }

            return response()->json(['barcode' => $barcode]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function obtenerInfoReciboetiquetas(Request $request)
    {
        $orderNum = $request->input('order_num');

        // Obtener información de recibo según el número de recibo
        $recibo = M_Receipts::where('order_num', $orderNum)->first();

        if ($recibo) {
            return response()->json([
                'success' => true,
                'data' => [
                    'delivery_date' => $recibo->delivery_date,
                    'customer' => $recibo->customer,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }




}




