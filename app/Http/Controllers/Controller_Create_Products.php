<?php

namespace App\Http\Controllers;

use App\Models\Model_Products;
use App\Models\Model_Receipt;
use Illuminate\Http\Request;

class Controller_Create_Products extends Controller
{

    public function index(Request $request)
    {
        $order_number = $request->input('order_num');
    
        $productos = Model_Products::where('state', 1)
            ->whereHas('recibo', function ($query) use ($order_number) {
                $query->where('order_num', $order_number);
            })
            ->get();
    
        $recibos = Model_Receipt::where('state', 1)->get();
    
        return view('Productos.index', compact('productos', 'order_number', 'recibos'));
    }
    


public function create()
{
    // Obtener recibos con estado 1 (asumiendo que 'estado' es un campo en el modelo Model_Receipt)
    $recibos = Model_Receipt::where('state', 1)->get();

    // Crear una instancia del modelo de producto (reemplaza Model_Product con el nombre real de tu modelo)
    $producto = new Model_Products();

    // Configurar la vista con los datos necesarios antes de la condición
    return view('Productos.create', compact('recibos'));
}

public function store(Request $request)
{
    $producto = new Model_Products();
    $producto->code_product = $request->code_product;
    $producto->description = $request->description;
    $producto->unit_measurement = $request->unit_measurement;
    $producto->amount = $request->amount;
    $producto->gross_weight = $request->gross_weight;
    $producto->packaging_weight = $request->packaging_weight;
    $producto->net_weight = $request->net_weight;
    $producto->order_num = $request->orden_num; // Asegúrate de usar 'orden_num' aquí si es el nombre correcto
    $producto->state = 1;
    $producto->save();
    
    return redirect(route('recibo.index'));
}



    /**
     * Display the specified resource.
     */
    public function show(string $order_number)
    {
        // Puedes implementar la lógica para mostrar un producto específico si es necesario.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Puedes implementar la lógica para editar un producto específico si es necesario.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Puedes implementar la lógica para actualizar un producto específico si es necesario.
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Puedes implementar la lógica para eliminar un producto específico si es necesario.
    }
}
