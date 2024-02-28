<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Tags extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "tags";
    protected $primaryKey = 'id_tag'; // Ajusta esto según la clave primaria real de tu modelo

    protected $fillable = ['order_num', 'sku', 'description', 'delivery_date', 'amount', 'weight', 'customer', 'type', 'content', 'product_status', 'color', 'barcode', 'state'];

    public function recibo()
    {
        return $this->belongsTo(M_Receipts::class, 'order_num', 'order_num')
            ->select('order_num', 'delivery_date', 'customer');
    }
    
    public function M_Products()
    {
        return $this->belongsTo(M_Products::class, 'sku', 'sku')->select('sku', 'description');
    }
    
    public function M_codeProducts()
    {
        return $this->belongsTo(M_codeProducts::class, 'sku', 'sku')->select('sku', 'description', 'barcode');
    }
}


