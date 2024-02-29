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
    public function index()
    {
        $recibos = M_Receipts::where('state', '1')->paginate(8);
        $suppliers = M_Suppliers::all(); // Obtén todos los proveedores

        return view('Recibo.index', compact('recibos', 'suppliers'));
    }

    public function filtrar(Request $request)
    {
        $numeroFormato = $request->input('numero_formato');

        $recibos = M_Receipts::when($numeroFormato, function ($query) use ($numeroFormato) {
            return $query->where('order_num', 'LIKE', '%' . $numeroFormato . '%');
        })->get();

        return view('recibo.lista_recibos', ['recibos' => $recibos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = M_Suppliers::orderBy('name', 'asc')->get(); // Ordenar proveedores alfabéticamente

        return view('Recibo.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $recibo = new M_Receipts($request->all());
        $recibo->state = 1;
        $recibo->save();

        return redirect(route('recibo.index'));
    }

    public function obtenerCodigosCliente($id)
    {
        $codigosClientes = M_Suppliers::where('id', $id)->pluck('code', 'id');

        return response()->json($codigosClientes);
    }

    public function edit(M_Receipts $recibo)
    {
        $suppliers = M_Suppliers::orderBy('name', 'asc')->get(); // Ordenar proveedores alfabéticamente

        return view('Recibo.edit', compact('recibo', 'suppliers'));
    }

    public function update(Request $request, M_Receipts $recibo)
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'origin' => 'required|string|max:255',
                'customer' => 'required|string|max:255',
                'code_customer' => 'required|string|max:255',
                'driver' => 'required|string|max:255',
                'plate' => 'required|string|max:255',
                'num_vehicle' => 'required|string|max:255',
                // Asegúrate de incluir las reglas de validación necesarias para otros campos si es necesario
            ]);
    
            // Actualizar el modelo con los datos del formulario y guardar automáticamente en la base de datos
            $recibo->origin = $request->input('origin');
            $recibo->customer = $request->input('customer');
            $recibo->code_customer = $request->input('code_customer');
            $recibo->driver = $request->input('driver');
            $recibo->plate = $request->input('plate');
            $recibo->num_vehicle = $request->input('num_vehicle');
            $recibo->save();    
            // Redireccionar a la vista index con un mensaje de éxito
            return redirect()->route('recibo.index')->with('success', 'Recibo actualizado correctamente.');
        } catch (\Exception $e) {
            // Manejar errores y redireccionar con un mensaje de error
            return redirect()->route('recibo.index')->with('error', 'Error al actualizar recibo: ' . $e->getMessage());
        }
    }
    
    
    
}