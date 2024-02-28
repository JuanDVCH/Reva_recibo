<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Products extends Model
{
    use HasFactory;
    protected $table = "product";
    protected $primaryKey = 'id_product'; // Ajusta esto según la clave primaria real de tu modelo
    protected $fillable = ['sku', 'description', 'unit_measurement', 'gross_weight', 'packaging_weight', 'net_weight', 'order_num', 'delivery_date', 'code_customer', 'notes', 'criterium','state'];

    public function recibo()
    {
        return $this->belongsTo(M_Receipts::class, 'order_num', 'order_num')
            ->select('order_num', 'delivery_date', 'code_customer');
    }

    public function M_Tags()
    {
        return $this->hasMany(M_Tags::class, 'sku', 'sku');
    }

    public function M_codeProducts()
    {
        return $this->belongsTo(M_codeProducts::class, 'sku', 'sku');
    }
}


