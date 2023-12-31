<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees_contactModel extends Model
{
    use HasFactory;


    // call table employees_contact
    protected $table = 'employees_contact';
    
    // call fillable column
    protected $fillable = [
        'employees_id',
        'phone',
        'email'
    ];
}
