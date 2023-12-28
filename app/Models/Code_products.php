<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code_products extends Model
{    protected $primaryKey = 'id_code_products';
    protected $table = 'code_products';
    protected $fillable = ['sku','barcode','description','category','state'];

    public function pulpos()
    {
        return $this->hasMany(Pulpo::class, 'sku', 'sku');
    }
    public function receipts()
    {
        return $this->hasMany(Model_Receipt::class, 'order_num', 'sku');
    }
}
