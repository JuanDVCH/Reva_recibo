<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_codeProducts extends Model
{
    protected $primaryKey = 'id_code_products';
    protected $table = 'code_products';
    protected $fillable = ['sku', 'barcode', 'description', 'category', 'state'];

    public function M_Tags()
    {
        return $this->hasMany(M_Tags::class, 'sku', 'sku');
    }
    public function receipts()
    {
        return $this->hasMany(M_Receipts::class, 'order_num', 'sku');
    }
    public static function obtenerDescripcionPorSku($sku)
    {
        $producto = self::where('sku', $sku)->first();

        return $producto ? $producto->description : null;
    }
    public static function obtenerBarcodePorSku($sku)
    {
        $producto = self::where('sku', $sku)->first();

        return $producto ? $producto->barcode : null;
    }


    public static function obtenerSkusPorOrden($orderNum)
    {
        return self::whereHas('receipts', function ($query) use ($orderNum) {
            $query->where('order_num', $orderNum);
        })->pluck('sku');
    }
    public function products()
    {
        return $this->hasMany(M_Products::class, 'sku', 'sku');
    }
}
