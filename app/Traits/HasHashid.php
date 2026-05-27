<?php

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids;

trait HasHashid
{
    /**
     * Get the hashid attribute
     */
    public function getHashidAttribute()
    {
        return Hashids::encode($this->getKey());
    }
    
    /**
     * Find a model by its hashid
     */
    public static function findByHashid($hashid)
    {
        $decoded = Hashids::decode($hashid);
        $id = $decoded[0] ?? null;
        
        return $id ? static::find($id) : null;
    }
    
    /**
     * Find a model by its hashid or fail
     */
    public static function findByHashidOrFail($hashid)
    {
        $model = static::findByHashid($hashid);
        
        if (!$model) {
            abort(404, 'Resource not found');
        }
        
        return $model;
    }
    
    /**
     * Get route key for implicit binding
     */
    public function getRouteKeyName()
    {
        return 'hashid';
    }
    
    /**
     * Resolve route binding
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return static::findByHashidOrFail($value);
    }
}