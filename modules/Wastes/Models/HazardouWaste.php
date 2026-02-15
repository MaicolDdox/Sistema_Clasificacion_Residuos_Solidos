<?php

namespace Modules\Wastes\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ProductiveUnits\Models\ProductiveUnit;

class HazardouWaste extends Model
{
    use HasFactory;

    protected $fillable = [
        'productive_unit_id',
        'user_id',
        'entry_date',
        'waste_type',
        'amount',
        'observations',
        'evidence_image',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
    ];

    public function productiveUnit(): BelongsTo
    {
        return $this->belongsTo(ProductiveUnit::class, 'productive_unit_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
