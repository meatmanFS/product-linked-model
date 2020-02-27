<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = ['name'];

    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributable');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
