<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remind extends Model
{ 
    protected $fillable = [
        'title',
        'start',
        'user_id'
    ];
    use HasFactory;
}
