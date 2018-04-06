<?php

namespace Advert;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;

class Advert extends Model
{
    protected $table = 'adverts';
    protected $fillable = ['title', 'rubric', 'description', 'image_names', 'region', 'phone', 'user_id', 'active', 'price'];

    public function getEnum($column)
    {
        return DB::select(DB::raw("SHOW COLUMNS FROM $this->table WHERE Field = '$column'"))[0]->Type;
    }
    public function changeEnum($column)
    {
        return DB::statement("ALTER TABLE $this->table MODIFY COLUMN rubric ENUM($column)");
    }
    public function cabinet(){
       return $this->belongsTo(\Advert\User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(\Advert\Comment::class);
     }

     public function users()
     {
         return $this->belongsTo(\Advert\User::class,'user_id');
     }

}
