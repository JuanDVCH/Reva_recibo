<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_Receipt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "receipts";
    protected $fillable = ['delivery_date','origin','customer','code_customer','driver','plate','num_vehicle','state'];

    public function productos()
    {
        return $this->hasMany(Model_Products::class, 'order_num', 'order_num');
    }
    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class, 'order_num', 'order_num');
    }
    public function codeProducts()
    {
        return $this->hasMany(Code_products::class, 'sku', 'order_num');
    }
}