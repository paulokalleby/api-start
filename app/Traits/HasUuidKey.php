<?php 

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuidKey 
{
    public function getKeyName()
    {
        return 'id';
    }

    public function getKeyType()
    {
        return 'uuid';
    }

    public function getIncrementing()
    {
        return false;
    }
    
    public static function booted()
    {
        static::creating( function ($model) {
            $model->{$model->getKeyName()} = (String) Str::uuid();
        });
    }
}