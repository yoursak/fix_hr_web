<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadImageApiController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->image) {
            // return true; 
            // Validate the incoming request
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
            ]);
            // Get the uploaded image file
            $image = $request->file('image');
            $path = public_path('upload_image/');
            $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
            $request->image->move($path, $imageName);

            // $image  = new Image();
            // $image->name = $imageName;
            // $image->save();

            // Return a response with information about the uploaded image
            return response()->json([
                'message' => 'Image uploaded successfully.',
                'image_path' => $imageName,
            ]);
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
