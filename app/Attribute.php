<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'type', 'value', 'created_from'];

    protected static $types = [
        [
            'name' => 'String',
            'type' => 'string'
        ],[
            'name' => 'Integer',
            'type' => 'integer'
        ],[
            'name' => 'Float',
            'type' => 'float'
        ],
    ];

    public static function getTypes()
    {
        return json_encode(self::$types);
    }

    public function getValue()
    {
        $return = '';
        switch ($this->type){
            case 'string':
                $return = (string)$this->value;
                break;
            case 'integer':
                $return = (int)$this->value;
                break;
            case 'float':
                $return = (float)$this->value;
                break;
        }
        return $return;
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'attributable');
    }

    public function productTypes()
    {
        return $this->morphedByMany(ProductType::class, 'attributable');
    }
}
