<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_Products extends Model
{
    // No es necesario especificar primaryKey y timestamps si sigues las convenciones de Laravel

    protected $table = "product";
    protected $fillable = ['sku', 'description', 'unit_measurement', 'amount', 'gross_weight', 'packaging_weight', 'net_weight', 'order_num', 'state'];

    public function recibo()
    {
        return $this->belongsTo(Model_Receipt::class, 'order_num', 'order_num');
    }

    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class, 'sku', 'sku');
    }

    public function code_products()
    {
        return $this->belongsTo(Code_products::class, 'sku', 'sku');
    }
}