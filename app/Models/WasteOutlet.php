<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteOutlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_date',
        'amount',
    ];
}
