<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // have no idea what is this used for
    use HasFactory;

    // attr that can be assigned
    protected $fillable = [
        "name",
        "description",
        "author",
        "status",
        "image_path",
    ];
}
