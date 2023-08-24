<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryEmployee extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'category_name',
    ];
    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
