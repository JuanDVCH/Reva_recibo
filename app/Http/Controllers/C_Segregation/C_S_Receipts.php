<?php

namespace App\Http\Controllers\C_Segregation;

use App\Models\M_Segregation\M_S_Receipts;
use App\Models\M_Suppliers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class C_S_Receipts extends Controller
{
    public function index(Request $request)
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

        return view('Segregation.S_receipt.S_index', compact('recibos', 'suppliers', 'totalRecibos'));
    }


    public function finalizados(Request $request)
    {
        $query = M_S_Receipts::where('state', '0');

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

        return view('Receipts.Recibo.finalizados', compact('recibos', 'suppliers', 'totalRecibos'));
    }



    public function filtrar(Request $request)
    {
        $numeroFormato = $request->input('numero_formato');

        $recibos = M_S_Receipts::when($numeroFormato, function ($query) use ($numeroFormato) {
            return $query->where('order_num', 'LIKE', '%' . $numeroFormato . '%');
        })->get();

        return view('Receipts.recibo.lista_recibos', ['recibos' => $recibos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = M_Suppliers::orderBy('name', 'asc')->get(); // Ordenar proveedores alfabéticamente

        return view('Segregation.S_receipt.S_create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $recibo = new M_S_Receipts($request->all());
        $recibo->state = 1;
        $recibo->save();

        return redirect()->route('Segregation.S_receipt.S_index')->with('nuevoRecibo', true);
    }


    public function obtenerCodigosCliente($id)
    {
        $codigosClientes = M_Suppliers::where('id', $id)->pluck('code', 'id');

        return response()->json($codigosClientes);
    }



    public function searchByDate(Request $request)
    {
        $date = $request->input('date');

        $recibos = M_S_Receipts::whereDate('delivery_date', $date)->get();

        return view('Segregation.S_receipt.S_index', compact('recibos'));
    }

    public function marcarComoFinalizado(Request $request, $order_num)
    {
        $recibo = M_S_Receipts::findOrFail($order_num);
        $recibo->state = 0;
        $recibo->save();

        return redirect()->route('Segregation.S_receipt.S_index')->with('success', 'Recibo marcado como finalizado');
    }
}


