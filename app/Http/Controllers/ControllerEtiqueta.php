<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model_Receipt;
use App\Models\Code_products;
use App\Models\Model_Products;
use App\Models\Etiqueta;
use PDF;
use Illuminate\Support\Facades\Log; // Add this line

//use Imagick;

class ControllerEtiqueta extends Controller
{
    public function index()
    {
        // Usar alias más descriptivos para mejorar la legibilidad
        $etiquetas = Etiqueta::select('rec.order_num as recibo_numero', 'prod.sku as sku_producto', 'tags.*')
            ->join('receipts as rec', 'tags.order_num', '=', 'rec.order_num')
            ->join('product as prod', 'tags.sku', '=', 'prod.sku')
            ->where('tags.state', 1)
            ->distinct()
            ->orderBy('tags.delivery_date', 'desc') // Corregir el orden por fecha de entrega
            ->paginate(15);

        // Obtener la lista de recibos y productos solo si es necesario
        $recibos = Model_Receipt::where('state', 1)->get();
        $productos = Model_Products::where('state', 1)->get();

        return view('etiquetas.index', compact('etiquetas', 'productos', 'recibos'));
    }

    public function create()
    {
        $recibos = Model_Receipt::where('state', 1)->get();
        $productos = Model_Products::where('state', 1)->get();
        return view('etiquetas.create', compact('recibos', 'productos'));
    }

    public function store(Request $request)
    {
        try {
            $etiqueta = new Etiqueta($request->all());
            $etiqueta->order_num = $request->order_num;
            $etiqueta->sku = $request->sku;
            $etiqueta->description = $request->description;
            $etiqueta->delivery_date = $request->delivery_date;
            $etiqueta->origin = $request->origin;
            $etiqueta->amount = $request->amount;
            $etiqueta->weight = $request->weight;
            $etiqueta->type = $request->type;
            $etiqueta->content = $request->content;
            $etiqueta->product_status = $request->product_status;
            $etiqueta->color = $request->color;
            $etiqueta->barcode = $request->barcode;
            $etiqueta->state = 1; // Suponiendo que 'state' es el nombre correcto del atributo
            $etiqueta->save();

            return redirect()->route('etiqueta.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al intentar guardar el producto.']);
        }
    }



    public function show(string $order_num)
    {
        $etiqueta = Etiqueta::where('order_num', $order_num)->first();

        return view('etiquetas.show', compact('etiqueta'));
    }

    public function imprimir($id_tag)
    {
        $etiqueta = Etiqueta::find($id_tag);

        // Generar el PDF con la librería PDF de Laravel
        $pdf = PDF::loadView('etiquetas.imprimir', compact('etiqueta'));

        // Descargar el PDF directamente
        return $pdf->stream('etiqueta.pdf');
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
    public function obtenerBarcodePorSku(Request $request)
    {
        try {
            $sku = $request->input('sku');
            $barcode = Code_products::where('sku', $sku)->value('barcode');

            if ($barcode === null) {
                throw new \Exception("No se encontró código de barras para el SKU: $sku");
            }

            return response()->json(['barcode' => $barcode]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }





}




