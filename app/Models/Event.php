<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'isEvents',
        'title',
        'start',
        'end',
        'color',
        'desc',
        'user_id'
    ];
    use HasFactory;
}
