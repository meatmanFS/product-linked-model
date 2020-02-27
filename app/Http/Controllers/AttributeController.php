<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Events\ProductTypeAttributeAdded;
use App\Events\ProductTypeAttributeDeleted;
use App\Http\Requests\StoreAttribute;
use App\Http\Resources\AttributeResource;
use App\ProductType;
use Illuminate\Http\Request;
use App\Http\Requests\RemoveAttribute;

class AttributeController extends Controller
{
    public function get(Request $request)
    {
        $productType = ProductType::findOrFail( $request->productTypeId );
        return AttributeResource::collection($productType->attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAttribute  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttribute $request)
    {
        $productType = ProductType::findOrFail( $request->productTypeId );
        $attribute = new Attribute($request->all(['name', 'type']));
        $attribute->save();
        $productType->attributes()->attach($attribute);
        event(new ProductTypeAttributeAdded($productType, $attribute));
        return new AttributeResource($attribute);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  RemoveAttribute $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemoveAttribute $request)
    {
        $attribute = Attribute::findOrFail($request->attributeId);
        $productType = ProductType::findOrFail($request->productTypeId);
        $productType->attributes()->detach($attribute);
        event(new ProductTypeAttributeDeleted($productType, $attribute->id));
        $isDeleted =  $attribute->delete();
        return response()->json([
            'status' => $isDeleted,
            'message' => !$isDeleted ? 'Error while deleting attribute' : null,
        ]);
    }
}
