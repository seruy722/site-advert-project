<?php

namespace Advert;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['user_name', 'comment', 'advert_id', 'user_id'];

    public function advert()
    {
        return $this->belongsTo(\Advert\Advert::class,'advert_id');
    }
}
