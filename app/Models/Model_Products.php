<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_Products extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "product";
    protected $primaryKey = 'id_product';
    protected $fillable = ['code_product', 'description', 'unit_measurement', 'amount', 'gross_weight', 'packaging_weight', 'net_weight', 'order_num', 'state'];

    public function recibo()
    {
        return $this->belongsTo(Model_Receipt::class, 'order_num', 'order_num');
    }

    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class, 'code_product', 'code_product');
    }
}


