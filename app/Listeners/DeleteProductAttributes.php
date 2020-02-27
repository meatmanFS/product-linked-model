<?php

namespace App\Listeners;

use App\Events\ProductTypeAttributeDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteProductAttributes implements ShouldQueue
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
     * @param  ProductTypeAttributeDeleted  $event
     * @return void
     */
    public function handle(ProductTypeAttributeDeleted $event)
    {
        foreach ($event->productType->product as $product){
            $attributesToRemove = $product->attributes()->where('created_from', $event->attributeId)->get();
            foreach ($attributesToRemove as $attribute){
                $product->attributes()->detach($attribute);
            }
        }
    }
}
