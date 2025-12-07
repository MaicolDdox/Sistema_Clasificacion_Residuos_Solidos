<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductiveUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'name',
        'description',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class);
    }

    public function hazardouWastes(): HasMany
    {
        return $this->hasMany(HazardouWaste::class);
    }
}
