<?php

namespace App\Events;

use App\Attribute;
use App\ProductType;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductTypeAttributeAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productType;
    public $attribute;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProductType $productType, Attribute $attribute)
    {
        $this->productType = $productType;
        $this->attribute = $attribute;
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
