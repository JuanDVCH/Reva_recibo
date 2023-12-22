<?php

namespace App\Http\Controllers;

use App\Models\Model_Products;
use Illuminate\Http\Request;
use App\Models\Pulpo;
use App\Models\Model_Receipt;

class ControllerPulpo extends Controller
{    
    public function index(Request $request)
    {
        $order_number = $request->input('order_num');

        $pulpos = Pulpo::where('state', 1)
            ->when($order_number, function ($query) use ($order_number) {
                $query->whereHas('recibo', function ($subQuery) use ($order_number) {
                    $subQuery->where('order_num', $order_number);
                });
            })
            ->get();

        $recibos = Model_Receipt::where('state', 1)->get();

        return view('pulpo.index', compact('pulpos', 'order_number', 'recibos'));
    }

    public function create()
    {
        $recibos = Model_Receipt::where('state', 1)->get();
        $pulpo = new Pulpo();
    
        return view('pulpo.create', compact('recibos'));
    }

    public function store(Request $request)
    {
        $pulpo = new Pulpo();
        $pulpo->supplier_code = $request->supplier_code;
        $pulpo->order_num = $request->orden_num;  // Corregido el nombre del campo
        $pulpo->notes = $request->notes;
        $pulpo->delivery_date = $request->delivery_date;
        $pulpo->sku = $request->sku;
        $pulpo->requested_quantity = $request->requested_quantity;
        $pulpo->criterium = $request->criterium;
        $pulpo->merchant_slug = $request->merchant_slug;
        $pulpo->merchant_channel_slug = $request->merchant_channel_slug;
        $pulpo->state = 1;
        $pulpo->save();

        return redirect(route('pulpo.index'));
    }
    public function show($order_num, $sku, $supplier_code)
{
    // Obtener el producto seleccionado
    $selectedProduct = Model_Products::where('order_num', $order_num)
        ->where('sku', $$sku)
        ->where('supplier_code', $supplier_code)
        ->first();

    // Obtener otros productos relacionados
    $relatedProducts = Model_Products::where('order_num', $order_num)
        ->where('sku', $$sku)
        ->where('supplier_code', '!=', $supplier_code) // Excluir el producto seleccionado
        ->get();

    return view('pulpo.exportar', compact('selectedProduct', 'relatedProducts'));
}
}
