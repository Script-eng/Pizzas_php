<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['cname', 'price'];

    public function pizzas()
    {
        return $this->hasMany(Pizza::class, 'category_name', 'cname');
    }
}
