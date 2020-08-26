<?php

namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract{

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'registered' => $user->created_at->diffForHumans()
        ];
    }
}