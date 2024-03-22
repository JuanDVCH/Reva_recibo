<?php

namespace App\Models\M_Segregation;

use App\Models\M_codeProducts;
use App\Models\M_Receipts;
use App\Models\M_Suppliers;
use App\Models\M_Tags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_S_Product_for_segregation extends Model
{
    public $timestamps = false;
    protected $table = "product_for_segregation";
    protected $primaryKey = 'S_product_id';

    protected $fillable = ['S_product_id', 'sku', 'description', 'net_weight', 'order_num','consecutive', 'state'];

    // Dentro de Model_Receipt.php

    public function recibo()
    {
        return $this->belongsTo(M_Receipts::class, 'order_num', 'order_num')
            ->select('order_num', 'delivery_date', 'code_customer');
    }
    public function tag()
    {
        return $this->belongsTo(M_Tags::class, 'S_product_id', 'S_product_id')
            ->select('id_tag');
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
