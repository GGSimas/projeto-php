<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'image'];

    protected $dates = ['deleted_at'];

    public function authors() {
        return $this->belongsToMany('App\Models\Authors', 'books_authors', 'book_id', 'author_id');
    }

    public function lendings()
    {
        return $this->belongsToMany('App\Models\Lendings', 'books_lendings');
    }
}
