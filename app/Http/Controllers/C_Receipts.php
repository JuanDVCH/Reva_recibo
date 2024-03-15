<?php

namespace App\Http\Controllers;

use App\Models\M_Receipts;
use App\Models\M_Suppliers;
use Illuminate\Http\Request;

class C_Receipts extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = M_Receipts::where('state', '1');

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

        return view('Receipts.Recibo.index', compact('recibos', 'suppliers', 'totalRecibos'));
    }


    public function finalizados(Request $request)
    {
        $query = M_Receipts::where('state', '0');

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

        $recibos = M_Receipts::when($numeroFormato, function ($query) use ($numeroFormato) {
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

        return view('Receipts.Recibo.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $recibo = new M_Receipts($request->all());
        $recibo->state = 1;
        $recibo->save();

        return redirect(route('Receipts.recibo.index'));
    }

    public function obtenerCodigosCliente($id)
    {
        $codigosClientes = M_Suppliers::where('id', $id)->pluck('code', 'id');

        return response()->json($codigosClientes);
    }

    public function edit(M_Receipts $recibo)
    {
        $suppliers = M_Suppliers::orderBy('name', 'asc')->get(); // Ordenar proveedores alfabéticamente

        return view('Receipts.Recibo.edit', compact('recibo', 'suppliers'));
    }

    public function update(Request $request, M_Receipts $recibo)
    {
        // Validación de la solicitud, si es necesario
        $request->validate([
            'delivery_date' => 'required|date',
            'origin' => 'required|string',
            'customer' => 'required|string',
            'code_customer' => 'required|string',
            'driver' => 'required|string',
            'plate' => 'required|string',
            'num_vehicle' => 'nullable|string',
            // Agrega las reglas de validación necesarias para otros campos
        ]);

        // Actualiza el recibo con los datos de la solicitud
        $recibo->update($request->all());

        // Puedes devolver una respuesta o redirigir a una vista después de la actualización
        return redirect()->route('recibo.index')->with('success', 'Recibo actualizado correctamente');
    }

    public function searchByDate(Request $request)
    {
        $date = $request->input('date');

        $recibos = M_Receipts::whereDate('delivery_date', $date)->get();

        return view('Receipts.receipts.index', compact('recibos'));
    }

    public function marcarComoFinalizado(Request $request, $order_num)
    {
        $recibo = M_Receipts::findOrFail($order_num);
        $recibo->state = 0;
        $recibo->save();

        return redirect()->route('Receipts.recibo.index')->with('success', 'Recibo marcado como finalizado');
    }

}