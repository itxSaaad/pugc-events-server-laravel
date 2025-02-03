<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Model
{
    use HasApiTokens, HasFactory, HasUuids;

    protected $fillable = ['id', 'name', 'email', 'password', 'role'];

    protected $keyType = 'string';

    protected $hidden = ['password'];
}
