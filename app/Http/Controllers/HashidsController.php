<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class HashidsController extends Controller
{
    public function encode($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'ID must be numeric'
            ]);
        }

        $hash = Hashids::encode($id);

        return response()->json([
            'original_id' => (int) $id,
            'encoded_hash' => $hash
        ]);

    }

    public function decode($hash)
    {
        $decoded = Hashids::decode($hash);

        if (count($decoded) > 0) {
            return response()->json([
                'hash' => $hash,
                'decoded_id' => $decoded[0]
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid or corrupted hash'
            ]);
        }
    }


}
