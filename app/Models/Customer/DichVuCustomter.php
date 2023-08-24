<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DichVuCustomter extends Model
{
    use HasFactory;
    protected $fillable = [
        'ma',
        'name',
    ];
}
