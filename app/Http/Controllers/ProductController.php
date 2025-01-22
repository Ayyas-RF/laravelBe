<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();
        return $data->count() > 0 ? response([
            "message" => "Product has been founded",
            'data' => $data
        ], 200) : response([
            "message" => "Product has been founded",
            'data' => $data
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "category_id" => "required|exists:categories,id",
            "product_name" => "required|unique:products,product_name",
            "product_image" => "required|image:jpeg,jpg,png",
            "price" => "required|integer",
            "stock" => "required|integer",
            "description" => "required|string",
        ]);
        $image_name = time() . "." . $request->product_image->extension();
        $request->product_image->move(public_path("upload/product"),
        $image_name);

        Product::create([
            "category_id" => $request->category_id,
            "product_name" => $request->product_name,
            "product_image" => url("/upload/product") . "/" . $image_name,
            "product_image_name" => $image_name,
            "price" => $request->price,
            "stock" => $request->stock,
            "description" => $request->description,
        ]);
        return response([
            "message" => "Product has been created succesfully!"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $data = Product::find($product);
        return isset($data) ?
        response([
            "message" => "Product detail has been founded",
            'data' => $data
        ], 200) : response ([
            "message" => "Product has founded",
            'data' => $data
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string
     $product)
    {
        $request->validate([
            "category_id" => "required|exists:categories,id",
            "product_name" => "required|unique:products,product_name",
            "price" => "required|integer",
            "stock" => "required|integer",
            "description" => "required|string",
        ]);
        $data = Product::find($product);
        if (!isset($data)) {
            return response([
                "message" => "Product has not found!"
            ], 404);
        }
        if (isset($request->product_image)){
            $request->validate([
                "product_image" => "required|image:jpeg,jpg,png"
            ]);

            $request->product_image->move(public_path("upload/product"), $data->product_image_name);
        }

        $data->category_id = $request->category_id;
        $data->product_name = $request->product_name;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->description = $request->description;
        $data->save();

        return response ([
            "message" => "Product has been updated!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $data = Product::find($product);
        if (!isset($data)) {
            return response([
                "message" => "Product has not found!"
            ], 404);
        }
        File::delete(public_path("upload/product") . "/" . $data->product_image_name);

        $data->delete();

        return response([
            "message" => "Product has been deleted!"
        ], 200);
    }
}
