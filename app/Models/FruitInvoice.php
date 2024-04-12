<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FruitInvoice extends Pivot
{
    use HasFactory;

    protected $fillable = ['fruit_id', 'invoice_id', 'quantity', 'amount'];
}
