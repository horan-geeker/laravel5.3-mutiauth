<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        if (!$request->file('file')) {
            return response()->json(['status' => 1, 'message' => 'file not exists']);
        }
        $path = \Storage::disk('public')->put('/images', $request->file('file'));
        return response()->json(['status' => 0, 'message' => config('app.url') . \Storage::url($path)]);
    }
}
