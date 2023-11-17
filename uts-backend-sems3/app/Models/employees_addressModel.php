<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees_addressModel extends Model
{
    use HasFactory;

    // call table employees_address
    protected $table = 'employees_address';

    // call fillable column
    protected $fillable = [
        'employees_id',
        'address'
    ];
}
