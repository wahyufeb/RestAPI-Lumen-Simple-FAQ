<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqDAO extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertanyaan', 'jawaban',
    ];

    protected $table = "qna";
}
