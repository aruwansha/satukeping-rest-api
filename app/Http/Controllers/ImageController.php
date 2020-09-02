<?php

namespace App\Http\Controllers;

use App\Image;
use App\Transformer\ImageTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ImageController extends Controller
{
    public function showImage()
    {
        $paginator = Image::Paginate(10);
        $imageList = $paginator->getCollection();
        $response = fractal()
            ->collection($imageList,new ImageTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
        return response()->json($response, 200);
    }

    public function showImageById($id)
    {
        if($image = Image::find($id)){
            return fractal()
            ->item($image)
            ->transformWith(new ImageTransformer)
            ->toArray();
        }

        return response()->json([
            'message' => 'Images not found'
        ], 404);
    }

    public function add(Request $request, Image $image)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:100',
            'image' => 'required|image|max:2000',
        ]);

        if ($request->hasFile('image')) {
            $imageName = 'Image-' . time() . '.';
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageToStorage = $imageName . $extension;
            $path = 'public/images';
            $request->file('image')->storeAs($path, $imageToStorage);
        }

        $storeToDatabase = $image->create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'image' => $imageToStorage,
        ]);

        $response = fractal()
            ->item($storeToDatabase)
            ->transformWith(new ImageTransformer)
            ->toArray();

        return response()->json($response, 201);
    }

    public function delete(Image $image)
    {
        $this->authorize('delete', $image);
        $path = 'public/images/';
        if (Storage::exists($path . $image->image)) {
            Storage::delete($path . $image->image);
            $image->delete();
            return response()->json([
                'message' => 'Images deleted'
            ]);
        }
    }
}
