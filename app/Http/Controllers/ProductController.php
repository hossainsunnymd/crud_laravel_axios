<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function productList(Request $request)
    {
        $data = Product::all();
        return response()->json(['message' => 'successfully received product', 'data' => $data]);
    }

    public function index(Request $request)
    {
        return view('pages.index');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|unique:products,product_id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_details' => 'nullable|string|max:1000',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $image = $request->file('images');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('image'), $imageName);

        Product::create(array_merge($validatedData, ['images' => $imageName]));
        return response()->json(['message' => 'Product created successfully!'], 201);
    }

    public function show(Request $request, $id)
    {
        $find = Product::where('product_id', 'Like', "%{$id}%")->orWhere('name', 'Like', "%{$id}%")->get();

        return response()->json(['data' => $find, 'message' => 'product find successfully']);
    }

    public function find(Request $request, $id)
    {
        $data = Product::find($id);
        return response()->json(['data' => $data, 'message' => 'find product successfully!']);
    }

    public function edit(Request $request, $id)
    {
        try {
          $validate=$request->validate([
                'product_id' => 'required|exists:products,product_id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'product_details' => 'nullable|string|max:1000',
                'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $input = $request->all();
            if ($request->hasFile('images')) {
                $image = $request->file('images');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $input['images'] = $imageName;
            }else{
                unset($input['images']);
            }


            Product::where('id', $id)->update($input);

            return response()->json(['message' => 'Product updated successfully!'], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }


    public function destroy(Request $request, $id)
    {
        Product::where('id', '=', $id)->delete();
        return response()->json(['message' => 'product delete successfully!']);
    }
}
