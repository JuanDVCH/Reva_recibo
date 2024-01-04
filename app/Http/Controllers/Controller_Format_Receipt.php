<?php

namespace App\Http\Controllers;

use App\Models\Model_Receipt;
use App\Models\Supplier;
use Illuminate\Http\Request;

class Controller_Format_Receipt extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recibos = Model_Receipt::where('state', '1')->get();
        $suppliers = Supplier::all(); // Obtén todos los proveedores
    
        return view('Recibo.index', compact('recibos', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all(); // Obtén todos los proveedores
    
        return view('Recibo.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $recibo = new Model_Receipt();
        $recibo->delivery_date = $request->delivery_date;
        $recibo->origin = $request->origin;

        // Asignar el cliente y el código del cliente desde la tabla suppliers
        $recibo->customer = $request->customer;
        $recibo->code_customer = $request->code_customer;

        $recibo->driver = $request->driver;
        $recibo->plate = $request->plate;
        $recibo->num_vehicle = $request->num_vehicle;
        $recibo->state = 1;
        $recibo->save();

        return redirect(route('recibo.index'));
    }

    public function obtenerCodigosCliente($id)
    {
        $codigosClientes = Supplier::where('id', $id)->pluck('code', 'id');

        return response()->json($codigosClientes);
    }

}
