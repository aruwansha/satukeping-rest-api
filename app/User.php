<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'api_token'
    ];

    protected $hidden = [
        'password', 'api_token',
    ];

    public function image()
    {
        return $this->hasMany(Image::class);
    }


    public function ownImage(Image $image)
    {
        return auth()->id() === $image->user->id;
    }

}
