<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Authors extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'surname'
    ];
    
    public function fullname() 
    {
        return $this->surname.', '.$this->name;
    }
    protected $dates = ['deleted_at'];

    public function books() {
        return $this->belongsToMany('App\Models\Books', 'books_authors', 'author_id', 'book_id');
    }
}
