<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Image extends Model
{
    protected $fillable = [
        'user_id', 'title', 'image'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
