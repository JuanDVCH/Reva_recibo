<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Receipts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "receipts";
    protected $fillable = ['delivery_date', 'origin', 'customer', 'code_customer', 'driver', 'plate', 'num_vehicle', 'state'];

    // Dentro de Model_Receipt.php

    public function productos()
    {
        return $this->hasMany(M_Products::class, 'order_num', 'order_num')
            ->with('recibo:order_num,delivery_date,code_customer');
    }

    public function etiquetas()
    {
        return $this->hasMany(M_Tags::class, 'order_num', 'order_num')
            ->with('recibo:order_num,delivery_date,customer');
    }
    public function M_codeProducts()
    {
        return $this->hasMany(M_codeProducts::class, 'sku', 'order_num');
    }
    public function supplier()
    {
        return $this->belongsTo(M_Suppliers::class, 'supplier_id'); // Ajusta 'supplier_id' según la columna real en tu tabla 'receipts'
    }
}