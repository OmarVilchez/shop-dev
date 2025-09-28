<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        try {
            if (!$request->hasFile('files')) {
                return response()->json(['success' => false, 'message' => 'No se recibió ninguna imagen'], 400);
            }

            $files = $request->file('files');
            $files = is_array($files) ? $files : [$files]; // Asegurar array

            $urls = [];
            foreach ($files as $file) {
                if ($file->isValid()) {
                    $path = $file->store('uploads', 'public');
                    // $urls[] = asset("storage/$path");
                    $urls[] = Storage::url($path);
                }
            }

            return response()->json(['success' => true, 'files' => $urls]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error interno en el servidor'], 500);
        }
    }
}
