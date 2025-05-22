<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxHistory extends Model
{
    use HasFactory;

    protected $fillable = ['income', 'tax_rate', 'tax_amount'];
}
