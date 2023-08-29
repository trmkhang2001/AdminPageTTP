<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoCustomer extends Model
{
    use HasFactory;
    protected $fillable = [
        'ma',
        'name',
        'address',
        'loai_dv',
        'phone',
        'email',
        'folder_id'
    ];
}
