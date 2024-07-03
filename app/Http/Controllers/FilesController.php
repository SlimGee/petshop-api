<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;

class FilesController extends Controller
{
    public function store(StoreFileRequest $request)
    {
        $file = $request->file('file');

        $path = $file->store('files');

        return response()->json([
            'path' => $path,
        ]);
    }
}
