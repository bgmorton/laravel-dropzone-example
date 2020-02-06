<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class MediaController extends Controller
{
    /**
     * Upload a file
     * Package laravel-directory-cleanup takes care of removing old, unused uploads - see the file of that name in the config dir
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'file' => 'required|file|image|max:2048',
        ]);

        //Save the uploaded file from the request to the uploads storage.  Media Library will read them from here when the post is saved
        $path = $request->file('file')->store('uploads');
        $file = $request->file('file');

        //Return the name of the file after upload, and the original name
        //These will be appended as hidden inputs to the posts form so that they can be processed after the post is saved
        return response()->json([
            'name' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Show an uploaded file
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Media $mediaItem, string $size = null)
    {
        try {

            //Get the specified size image
            if (in_array($size, ['thumb', 'large'])) {
                return response()->download($mediaItem->getPath($size), $mediaItem->name);
            }

            //Return the original image if no valid size supplied
            else {
                return response()->download($mediaItem->getPath(), $mediaItem->name);
            }

        } catch (FileNotFoundException $e) {
            //FileNotFoundExceptions thrown as 500 by default, want to make them a 404 instead
            abort(404);
        }
    }

}
