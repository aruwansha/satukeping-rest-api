<?php

namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Image;

class ImageTransformer extends TransformerAbstract{
    public function transform(Image $image)
    {
        return [
            'user_id' => $image->user_id,
            'title' => $image->title,
            'image' => $image->image,
            'posted' => $image->created_at->diffForHumans(),
        ];
    }
}