<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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
            // 'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            '_datetime' => 'required',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            // 'image' => $img_names[0]['image'], // get the first image
            '_datetime' => date("Y-m-d H:i:s", strtotime($request->_datetime)),
        ]);

        /**
         * if the front over file exists
         */
        $path = null;
        // loop through the request and check if the image is not null
        // if it is not null then upload the image
        // if it is null then do not upload the image
        $img_names = [];
        foreach($request->file('images') as $key => $value){
            $value->getClientOriginalName();
            $path = $value->store('public/cover');
            $path = explode('/',$path);
            $path = 'storage/cover/'.end($path);
            $img_names[] = [
                'product_id' => $product->id,
                'image' => $path,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }

        Product::where('id',$product->id)->update([
            'image' => $img_names[0]['image']
        ]);

        ProductImage::insert($img_names); // insert the new photos

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
            // 'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            '_datetime' => 'required',
        ]);
        /**
         * if the front over file exists
         */
        $path = null;

        // loop through the request and check if the image is not null
        // if it is not null then upload the image
        // if it is null then do not upload the image
        $img_names = [];
        foreach($request->file('images') as $key => $value){
            $value->getClientOriginalName();
            $path = $value->store('public/cover');
            $path = explode('/',$path);
            $path = 'storage/cover/'.end($path);
            $img_names[] = [
                'product_id' => $request->id,
                'image' => $path,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }
        ProductImage::where('product_id',$request->id)->delete(); // remove the old photos
        ProductImage::insert($img_names); // insert the new photos
        /**
         * update the product
         */
        $_product = $product->where('id',$request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $img_names[0]['image'], // select the first image and make it as the product image
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
