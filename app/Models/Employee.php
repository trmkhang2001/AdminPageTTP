<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'ma',
        'name',
        'address',
        'phone',
        'email',
        'category_id',
        'charge_id',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryEmployee::class);
    }
}
