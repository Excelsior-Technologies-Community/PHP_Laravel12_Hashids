<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\Product;

class TestHashids extends Command
{
    protected $signature = 'hashids:test';
    protected $description = 'Test Hashids functionality';

    public function handle()
    {
        $this->info('Testing Hashids...');
        
        // Test encoding
        $id = 100;
        $hash = Hashids::encode($id);
        $this->info("ID: {$id} → Hash: {$hash}");
        
        // Test decoding
        $decoded = Hashids::decode($hash);
        $this->info("Hash: {$hash} → ID: {$decoded[0]}");
        
        // Test with database
        $product = Product::first();
        if ($product) {
            $this->info("Product: {$product->name}");
            $this->info("Hash ID: {$product->hashid}");
        }
        
        $this->info('✅ Hashids test completed!');
    }
}