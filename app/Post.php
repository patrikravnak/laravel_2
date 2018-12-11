<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Table name
    protected $table = 'Posts';
    //Primary key
    public $primarykey = 'id';
    //Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
    return $this->hasMany('App\Comment');
    }
}
