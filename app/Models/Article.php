<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'body', 'category_id', 'user_id'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function hashTags()
    {
        return $this->belongsToMany(HashTag::class);
    }
    public function getRouteKeyName()
    {
        return 'id'; 
    }
}