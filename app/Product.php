<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'sku'];

    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributable');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}
