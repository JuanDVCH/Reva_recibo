<?php

namespace App\Http\Controllers;

use App\Models\Code_products;
use Illuminate\Http\Request;
use App\Models\Pulpo;
use App\Models\Model_Receipt;
use App\Models\Supplier;
use App\Models\Model_Products;

class ControllerPulpo extends Controller
{
    public function index(Request $request)
    {
        $order_number = $request->input('order_num');

        $skus = Code_products::all();
        // Cargar proveedores
        $suppliers = Supplier::all(); // Ajusta esto según tus necesidades

        // Cargar pulpos con la relación 'supplier'
        $pulpos = Pulpo::with('supplier')
            ->where('state', 1)
            ->when($order_number, function ($query) use ($order_number) {
                $query->whereHas('supplier', function ($subQuery) use ($order_number) {
                    $subQuery->where('order_num', $order_number);
                });
            })
            ->get();

        $recibos = Model_Receipt::where('state', 1)->get();


        // Pasar $suppliers y $skus a la vista
        return view('pulpo.index', compact('pulpos', 'order_number', 'recibos', 'suppliers', 'skus'));
    }


    public function create(Request $request)
    {
        $recibos = Model_Receipt::where('state', 1)->get();
        $pulpo = new Pulpo();
        
        // Obtener todos los SKU asociados al número de orden seleccionado
        $skus = [];
        $selectedOrderNum = $request->input('selectedOrderNum');
        if ($selectedOrderNum) {
            $skus = Model_Products::where('order_num', $selectedOrderNum)->distinct('sku')->pluck('sku');
        }
    
        return view('pulpo.create', compact('pulpo', 'recibos', 'skus'));
    }


    public function store(Request $request)
    {
        $pulpo = new Pulpo();
        $pulpo->fill($request->except('supplier_code', 'sku')); // Rellenar datos básicos
        $pulpo->state = 1;
        $pulpo->save();
    
        // Asociar relaciones
        $supplier = Supplier::where('code', $request->supplier_code)->first();
        $sku = Code_products::where('sku', $request->sku)->first();
    
        if ($supplier) {
            $pulpo->supplier()->associate($supplier);
        }
    
        if ($sku) {
            $pulpo->code_products()->associate($sku);
        }
    
        $pulpo->save(); // Guardar nuevamente para actualizar las relaciones
    
        return redirect(route('pulpo.index'));
    }
    public function show($order_num, $sku, $supplier_code)
    {
        // Obtener el producto seleccionado
        $selectedProduct = Model_Products::where('order_num', $order_num)
            ->where('sku', $sku)
            ->where('supplier_code', $supplier_code)
            ->first();

        // Obtener otros productos relacionados
        $relatedProducts = Model_Products::where('order_num', $order_num)
            ->where('sku', $sku)
            ->where('supplier_code', '!=', $supplier_code) // Excluir el producto seleccionado
            ->get();

        // Obtener información del proveedor a través de la relación en Pulpo
        $supplierInfo = Pulpo::where('order_num', $order_num)
            ->where('sku', $sku)
            ->where('supplier_code', $supplier_code)
            ->with('supplier')
            ->first();

        $skuInfo = Pulpo::where('order_num', $order_num)
            ->where('sku', $sku)
            ->with('code_products')
            ->first();

        return view('pulpo.exportar', compact('selectedProduct', 'relatedProducts', 'supplierInfo', 'skuInfo'));
    }

    public function obtenerSkus(Request $request)
    {
        $orderNum = $request->input('orderNum');

        // Obtén los SKUs asociados al número de recibo
        $skus = Model_Products::where('order_num', $orderNum)->distinct('sku')->pluck('sku');

        return response()->json($skus);
    }
}
