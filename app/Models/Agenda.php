<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = 'agenda';
    // sama dengan fillable
    // protected $guarded = [];

    protected $fillable = [
        'image',
        'title',
        'deskripsi',
    ];
}