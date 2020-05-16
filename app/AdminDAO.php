<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminDAO extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'name', "password", 
    ];

    protected $hidden = [
      'password', 'id'
    ];

    protected $table = 'admin';

    protected $primaryKey = 'id';
}
