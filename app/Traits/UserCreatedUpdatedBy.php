<?php 

namespace App\Traits ; 
use Illuminate\Support\Facades\Auth ;
trait UserCreatedUpdatedBy
{
    public static function bootUserCreatedUpdatedBy()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = auth()->user()->id;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });

        // updating updated_by when model is updated
        // static::updating(function ($model) {
        //     if (!$model->isDirty('updated_by')) {
        //         $model->updated_by = Auth::user()->id;
        //     }
        // });
    }
}
