<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $fillable = [
        'pname',
        'category_name',
        'vegetarian'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_name', 'cname');
    }
}
