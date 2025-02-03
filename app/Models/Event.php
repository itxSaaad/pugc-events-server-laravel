<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'department', 'date', 'time', 'location', 'created_by'];
    public $incrementing = false;
    protected $keyType = 'string';
}
