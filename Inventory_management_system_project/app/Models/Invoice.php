<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\InvoiceProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable =['total', 'discount', 'vat', 'payable', 'user_id', 'customer_id'];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
