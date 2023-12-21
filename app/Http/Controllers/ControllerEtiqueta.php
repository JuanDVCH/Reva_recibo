<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model_Receipt;
use App\Models\Model_Products;
use App\Models\Etiqueta;
use PDF;
//use Imagick;

class ControllerEtiqueta extends Controller
{

    public function index()
    {
        $etiquetas = Etiqueta::select('rec.order_num as ctgnombre', 'prod.code_product as prodcode_product', 'tags.*')
            ->join('receipts as rec', 'tags.order_num', '=', 'rec.order_num')
            ->join('product as prod', 'tags.code_product', '=', 'prod.code_product')
            ->where('tags.state', '1')
            ->distinct()
            ->orderBy('delivery_date', 'desc') // Ordenar por fecha de entrega de forma descendente
            ->paginate(15);

            $recibos = Model_Receipt::where('state', 1)->get();
            $productos = Model_Products::where('state', 1)->get();

        return view('etiquetas.index', compact('etiquetas','productos','recibos'));
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
        
        return redirect()->route('etiqueta.index');
        //return redirect(route('etiqueta.index'))->with('agregar', 'continuar');
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

}
    
    


