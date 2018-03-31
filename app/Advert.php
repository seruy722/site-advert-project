<?php

namespace Advert;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;
class Advert extends Model
{
    protected $table = 'adverts';
    protected $fillable = ['title', 'rubric', 'description', 'image_names', 'region', 'phone', 'user_id', 'active','price'];

    public function getEnum($column)
    {
       return DB::select(DB::raw("SHOW COLUMNS FROM $this->table WHERE Field = '$column'"))[0]->Type;
    }
    public function changeEnum($column)
    {
    //    return DB::statement("ALTER TABLE purchases CHANGE ref ref ENUM($column)");
    return DB::statement("ALTER TABLE $this->table MODIFY COLUMN rubric ENUM($column)");
    //    return DB::statement("ALTER TABLE $this->table CHANGE `rubric` `rubric` ENUM($column) default NULL;");
    }


    
}
