<?php

namespace App\Listeners;

use App\Attribute;
use App\Events\ProductTypeAttributeAdded;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddProductAttributes implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductTypeAttributeAdded  $event
     * @return void
     */
    public function handle(ProductTypeAttributeAdded $event)
    {
        foreach ($event->productType->product as $product){
            $newAttribute = new Attribute([
                'name' => $event->attribute->name,
                'type' => $event->attribute->type,
                'created_from' => $event->attribute->id,
            ]);
            $newAttribute->save();

            $product->attributes()->attach($newAttribute);
        }
    }
}
