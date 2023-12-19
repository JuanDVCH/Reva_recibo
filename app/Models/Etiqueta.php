<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "tags";
    protected $primaryKey = 'id_tag'; // Ajusta esto según la clave primaria real de tu modelo

    protected $fillable = ['order_num', 'code', 'description', 'date', 'amount', 'weight', 'origin', 'type', 'content','product_status','color','barcode', 'state'];
    public function recibo()
    {
        return $this->belongsTo(Model_Receipt::class, 'order_num', 'order_num');
    }
    public function producto()
    {
        return $this->belongsTo(Model_Products::class, 'code_product', 'code_product')->select('code_product', 'description');
    }
}

