<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Suppliers extends Model
{
    protected $primaryKey = 'id_suppliers';
    protected $table = 'suppliers';
    protected $fillable = ['code', 'name', 'state'];



    public function receipts()
    {
        return $this->hasMany(M_Receipts::class, 'supplier_id'); // Ajusta 'supplier_id' según la columna real en tu tabla 'receipts'
    }

}

