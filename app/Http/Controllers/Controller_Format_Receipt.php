<?php
namespace App\Http\Controllers;

use App\Models\Model_Receipt;
use Illuminate\Http\Request;

class Controller_Format_Receipt extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recibos = Model_Receipt::where('state', '1')->get();
        return view('Recibo.index', compact('recibos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Recibo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $recibo = new Model_Receipt();
        $recibo->delivery_date = $request->delivery_date;
        $recibo->origin = $request->origin;
        $recibo->customer = $request->customer;
        $recibo->code_customer = $request->code_customer;
        $recibo->driver = $request->driver;
        $recibo->plate = $request->plate;
        $recibo->num_vehicle = $request->num_vehicle;
        $recibo->state = 1;
        $recibo->save();

        return redirect(route('recibo.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($order_num)
    {
        $recibo = Model_Receipt::where('order_num', $order_num)->firstOrFail();
        return view('Productos.modal', compact('recibo'));
    }

    public function showPulpo($order_num)
    {
        $recibo = Model_Receipt::where('order_num', $order_num)->firstOrFail();
        return view('pulpo.modal', compact('recibo'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Implementar lógica para mostrar el formulario de edición
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Implementar lógica para actualizar el recibo
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Implementar lógica para eliminar un recibo
    }
}
