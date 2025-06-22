<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false; // if your 'roles' table doesn't use timestamps

    protected $fillable = ['name'];

    // Optional: Define relationship to users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}