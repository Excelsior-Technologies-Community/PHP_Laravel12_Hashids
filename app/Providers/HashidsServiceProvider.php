<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Vinkla\Hashids\Facades\Hashids;

class HashidsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Add custom macro for encoding arrays
        Hashids::macro('encodeArray', function ($numbers) {
            $encoded = [];
            foreach ($numbers as $number) {
                $encoded[] = Hashids::encode($number);
            }
            return $encoded;
        });
        
        // Add custom macro for decoding arrays
        Hashids::macro('decodeArray', function ($hashes) {
            $decoded = [];
            foreach ($hashes as $hash) {
                $result = Hashids::decode($hash);
                if (!empty($result)) {
                    $decoded[] = $result[0];
                }
            }
            return $decoded;
        });
    }
    
    public function register()
    {
        //
    }
}