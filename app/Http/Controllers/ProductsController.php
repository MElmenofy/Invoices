<?php

namespace App\Http\Controllers;
use App\Products;
use App\sections;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;
use App\Http\Requests\StoreProductsRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sections = sections::all();
        $products = Products::all();
        return view('products.products', compact('sections', 'products'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductsRequest $request)
    {
        //
        $validated = $request->validated();
        Products::create([
            'product_name'=> $request->product_name,
            'description'=> $request->description,
            'section_id'=> $request->section_id,
        ]);
        Session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;

        $products = Products::findOrFail($request->pro_id);

        $products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();

    }
        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $products = Products::findOrFail($request->pro_id);
        $products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
