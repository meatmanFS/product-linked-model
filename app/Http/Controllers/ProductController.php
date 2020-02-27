<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Http\Requests\SetProductType;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateAttributesRequest;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductTypeResource;
use App\Product;
use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function getType(Product $product)
    {
        return new ProductTypeResource($product->productType);
    }

    public function getAttributes(Product $product)
    {
        return AttributeResource::collection($product->attributes);
    }

    public function updateAttributes(Product $product, UpdateAttributesRequest $request)
    {
        $productAttributes = $request->all('productAttributes');
        $attributes = !empty($productAttributes['productAttributes'])
            ? $productAttributes['productAttributes']
            : [];

        foreach ($product->attributes as $productAttribute){
            foreach ($attributes as $attribute) {
                if(
                    isset($attribute['id'])
                    && $productAttribute->id === $attribute['id']
                    && isset($attribute['value'])
                ){
                    $productAttribute->value = $attribute['value'];
                    $productAttribute->save();
                }
            }

        }
    }

    public function searchProducts(Request $request)
    {
        $productAttributes = $request->all('productAttributes');
        $attributes = !empty($productAttributes['productAttributes'])
            ? $productAttributes['productAttributes']
            : [];

        $productType = ProductType::find($request->productTypeId);
        $cacheKey = md5(json_encode($attributes).$request->productTypeId);
        $searchCache = Cache::get($cacheKey);
        if(!empty($searchCache)){
            return $searchCache;
        }
        if($productType){
            $productsQuery = $productType->product();
        } else {
            $productsQuery = Product::query();
        }

        $products = $productsQuery->whereHas('attributes', function ($query) use($attributes) {
            foreach ($attributes as $attribute){
                if(empty($attribute['value'])){
                    continue;
                }
                $query->where([
                    ['created_from', $attribute['id']],
                    ['value', $attribute['value']]
                ]);
            }
        });
        $return = ProductResource::collection($products->get());
        Cache::put($cacheKey, $return, now()->addMinutes(10));
        return $return;
    }

    public function setType(SetProductType $productType)
    {
        $product = Product::findOrFail($productType->productId);
        $productType = ProductType::findOrFail($productType->productTypeId);
        if(
            empty($product->productType)
            || (
                !empty($product->productType)
                && $product->productType->id !== $productType->id
            )
        ){ // set different product type or no product type is set
            $product->attributes()->detach();
            // copy the attributes from the product type to product
            foreach ($productType->attributes as $attribute) {
                $newAttribute = new Attribute([
                    'name' => $attribute->name,
                    'type' => $attribute->type,
                    'created_from' => $attribute->id,
                ]);
                $newAttribute->save();
                $product->attributes()->attach($newAttribute);
            }
        }

        $product->productType()->associate($productType)->save();
        return AttributeResource::collection($product->attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProduct $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        $data = $request->only(['name', 'sku']);
        $product = new Product($data);
        $product->save();
        return redirect(route('products.edit', $product));
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreProduct $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, Product $product)
    {
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->save();
        return redirect(route('products.edit', $product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect(route('products.index'));
    }
}
