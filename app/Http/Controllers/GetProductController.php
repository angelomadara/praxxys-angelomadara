<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GetProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if($request){
            $products = Product::select('*')->with('images');

                if($request->q){
                    $products->where(function($query) use ($request){
                        $query->where('name','like','%'.$request->q.'%')
                            ->orWhere('description','like','%'.$request->q.'%');
                    });
                }

                if($request->category){
                    $products->orWhere(function($query) use ($request){
                        $query->where('category','=',$request->category);
                    });
                }

            return $products->latest()->paginate(config('paginate.default'));
        }
        return Product::with('images')->latest()->all();
    }
}
