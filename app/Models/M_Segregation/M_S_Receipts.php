<?php

namespace App\Models\M_Segregation;

use App\Models\M_codeProducts;
use App\Models\M_Products;
use App\Models\M_Suppliers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_S_Receipts extends Model
{
    public $timestamps = false;
    protected $table = "s_receipts";
    protected $primaryKey = 'format_number';

    protected $fillable = ['format_number', 'order_num', 'delivery_date', 'customer', 'code_customer', 'state'];

    // Dentro de Model_Receipt.php

    public function s_productos()
    {
        return $this->hasMany(M_S_Products::class, 'order_num', 'order_num')
            ->with('recibo:order_num,delivery_date,code_customer');
    }

    public function s_etiquetas()
    {
        return $this->hasMany(M_S_Tags::class, 'order_num', 'order_num')
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