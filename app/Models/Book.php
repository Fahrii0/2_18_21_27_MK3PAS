<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Peminjaman;

class Book extends Model
{
    protected $fillable =
        [
            'category_id',
            'title',
            'author',
            'publisher',
            'published_date'
        ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

        public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}

