<?php

namespace App\Events;

use App\Attribute;
use App\ProductType;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductTypeAttributeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productType;
    public $attributeId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProductType $productType, $attributeId)
    {
        $this->productType = $productType;
        $this->attributeId = $attributeId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //
    }
}
