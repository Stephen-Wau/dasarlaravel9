<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klub extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $primaryKey = 'number';

    protected $fillable = [
        'number',
        'image',
        'name',
        'sex',
        'dob',
        'position',
    ];
}
