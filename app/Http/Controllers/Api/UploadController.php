<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        $path = \Storage::disk('public')->put('/images', $request->file('file'));
        return response()->json(['filename'=>config('app.url').\Storage::url($path)]);
    }
}
