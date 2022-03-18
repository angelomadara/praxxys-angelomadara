<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('name')->get();
        return view('products.index',[
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('name')->get();
        return view('products.create-product-form',[
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:1024',
            'category' => 'required|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            '_datetime' => 'required',
        ]);
        /**
         * if the front over file exists
         */
        $path = null;
        if($request->file('image')){
            $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->store('public/cover');
            $path = explode('/',$path);
            $path = 'storage/cover/'.end($path);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $path,
            '_datetime' => date("Y-m-d H:i:s", strtotime($request->_datetime)),
        ]);

        return response([
            'message' => 'Product created successfully',
            'product' => $product,
            'status' => 'success'
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::select('name')->get();
        $product = Product::find($product->id);
        return view('products.update-product-form',[
            'categories' => $categories,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:1024',
            'category' => 'required|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            '_datetime' => 'required',
        ]);
        /**
         * if the front over file exists
         */
        $path = null;
        if($request->file('image')){
            $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->store('public/cover');
            $path = explode('/',$path);
            $path = 'storage/cover/'.end($path);
        }

        /**
         * update the product
         */
        $_product = $product->where('id',$request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $path,
            '_datetime' => date("Y-m-d H:i:s", strtotime($request->_datetime)),
        ]);

        return response([
            'message' => 'Product updated successfully',
            'product' => $_product,
            'status' => 'success'
        ],Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
