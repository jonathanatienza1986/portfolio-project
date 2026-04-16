<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mem extends Model
{
    /** @use HasFactory<\Database\Factories\MemFactory> */
    use HasFactory;
    protected $guarded = ['id'];
}
