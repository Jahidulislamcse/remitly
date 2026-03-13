<?php 

namespace App\Traits ; 
use App\Models\Scopes\GlobalWhereScope ;

trait GlobalWhere
{
    

    public static function bootGlobalWhere()
    {
        static::addGlobalScope(new GlobalWhereScope);
    }

}



