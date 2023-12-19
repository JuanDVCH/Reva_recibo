<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;
use App\Models\Model_Receipt;
use App\Models\Model_Products;
use App\Models\Etiqueta;
use PDF;
use Illuminate\Http\Response;

class ControllerEtiqueta extends Controller
{

    public function index()
    {
        $etiquetas = Etiqueta::select('rec.order_num as ctgnombre', 'prod.code_product as prodcode_product', 'tags.*')
            ->join('receipts as rec', 'tags.order_num', '=', 'rec.order_num')
            ->join('product as prod', 'tags.code_product', '=', 'prod.code_product')
            ->where('tags.state', '1')
            ->distinct()
            ->get();

        return view('etiquetas.index', compact('etiquetas'));
    }

    public function create()
    {
        $recibos = Model_Receipt::where('state', 1)->get();
        $productos = Model_Products::where('state', 1)->get();
        return view('etiquetas.create', compact('recibos', 'productos'));
    }

    public function store(Request $request)
    {
        $etiqueta = new Etiqueta($request->all());
        $etiqueta->order_num = $request->order_num;
        $etiqueta->code_product = $request->code_product;
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

        return redirect(route('etiqueta.index'))->with('agregar', 'continuar');
    }

    public function show(string $order_num)
    {
        $etiqueta = Etiqueta::where('order_num', $order_num)->first();

        return view('etiquetas.show', compact('etiqueta'));
    }

    public function imprimir($id_tag)
    {
        $etiqueta = Etiqueta::find($id_tag);

        // Generar código de barras
        $barcode = QrCode::format('png')->size(300)->generate($etiqueta->barcode);

        // Convierte la imagen a base64
        $barcodeImage = base64_encode($barcode);

        // Generar el PDF con la librería PDF de Laravel
        $pdf = PDF::loadView('etiquetas.imprimir', compact('etiqueta', 'qrCodeImage'));

        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();

        // Retorna la respuesta con el contenido del PDF
        // Retorna la vista con los datos
        return view('etiquetas.imprimir', compact('etiqueta', 'barcodeImage'));
    }

    public function edit(string $id)
    {
        $etiqueta = Etiqueta::find($id);

        return view('etiquetas.edit', compact('etiqueta', 'barcodeImage'));
    }

    public function update(Request $request, string $id)
    {
        $etiqueta = Etiqueta::find($id);

        // Lógica de actualización aquí

        return redirect()->route('etiquetas.index')->with('success', 'Etiqueta actualizada exitosamente');
    }

    public function destroy(string $id)
    {
        $etiqueta = Etiqueta::find($id);
        $etiqueta->delete();

        return redirect()->route('etiquetas.index')->with('success', 'Etiqueta eliminada exitosamente');
    }
}
