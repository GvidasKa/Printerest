<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    protected $fillable = [
    'title','description','img'
];
//    public function comments(){
//        return $this->hasMany('App\Comment');
//    }
//    public function user(){
//        return $this->belongsTo('App\User');
//    }
}
