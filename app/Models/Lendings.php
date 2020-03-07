<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lendings extends Model
{
    Use SoftDeletes;

    protected $dates = ['deleted_at', ];
    protected $fillable = ['user_id', 'end_date','date_start','date_finish'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function books()
    {
        return $this->belongsToMany('App\Models\Books', 'books_lendings','lending_id','book_id');
    }
}
