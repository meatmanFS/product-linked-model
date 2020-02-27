<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\ProductType;
use App\Http\Requests\StoreProductType;
use App\Http\Resources\ProductTypeResource;

class ProductTypeController extends Controller
{
    public function get()
    {
        $productTypes = ProductType::get();
        return ProductTypeResource::collection($productTypes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productTypes = ProductType::paginate(10);
        return view('productType.index', compact('productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProductType  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductType $request)
    {
        $data = $request->only(['name']);
        $productType = new ProductType($data);
        $productType->save();
        return redirect(route('productTypes.edit', $productType));
    }

    /**
     * Display the specified resource.
     *
     * @param  ProductType $productType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductType $productType)
    {
        return view('productType.show', compact('productType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductType $productType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductType $productType)
    {
        $attributeTypes = Attribute::getTypes();
        return view('productType.edit', compact('productType', 'attributeTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreProductType  $request
     * @param  ProductType $productType
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductType $request, ProductType $productType)
    {
        $productType->name = $request->name;
        $productType->save();
        return redirect(route('productTypes.edit', $productType));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductType $productType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();
        return redirect(route('productTypes.index'));
    }
}
