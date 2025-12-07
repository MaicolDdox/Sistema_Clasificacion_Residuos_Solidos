<?php

namespace Modules\Areas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ProductiveUnits\Models\ProductiveUnit;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function productiveUnits(): HasMany
    {
        return $this->hasMany(ProductiveUnit::class);
    }
}
