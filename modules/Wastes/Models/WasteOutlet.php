<?php

namespace Modules\Wastes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteOutlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_date',
        'amount',
    ];

    protected $casts = [
        'outlet_date' => 'date',
    ];
}
