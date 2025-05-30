<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TestController extends Controller
{
    public function testTranslation(Request $request)
    {
        // dd();
        return response()->json([
            // 'locale' => $locale,
            // 'message' => $message,
            'raw_message' => 'sssss',
            // 'validation_message' => __('validation.required', ['attribute' => 'name'])
        ]);
    }
} 