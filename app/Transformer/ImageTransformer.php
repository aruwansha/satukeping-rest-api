<?php

namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Image;

class ImageTransformer extends TransformerAbstract{
    public function transform(Image $image)
    {
        return [
            'id' => $image->id,
            'title' => $image->title,
            'image' => $image->image,
            'posted' => $image->created_at->diffForHumans(),
        ];
    }
}