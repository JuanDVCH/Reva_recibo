<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_Products extends Model
{
    use HasFactory;
    protected $table = "product";

    protected $fillable = [
        'sku',
        'description',
        'unit_measurement',
        'amount',
        'gross_weight',
        'packaging_weight',
        'net_weight',
        'order_num',
        'state',
        'delivery_date',
        'code_customer',
        'notes',
        'criterium',
    ];

    public function recibo()
    {
        return $this->belongsTo(Model_Receipt::class, 'order_num', 'order_num')
            ->select('order_num', 'delivery_date', 'code_customer');
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


