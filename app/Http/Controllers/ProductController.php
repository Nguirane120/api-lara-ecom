<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }
    
    public function store(Request $request)
    {
        

        $validator = Validator::make($request->all(),[
            'category_id' => 'required',
            'slug' => 'required',
            'name' => 'required',
            'brand' => 'required',
            'selling_price' => 'required',
            'original_price' => 'required',
            'qt' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png',
        ]);


        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ]);
        }
        else
        {
            $product = new Product();
            $product->category_id = $request->input('category_id');
            $product->slug = $request->input('slug');
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->meta_title = $request->input('meta_title');
            $product->meta_keywords = $request->input('meta_keywords');
            $product->meta_description = $request->input('meta_description');
            $product->brand = $request->input('brand');
            $product->qt = $request->input('qt');
            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');

            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() .' . '.$extension;
                $file->move('uploads/products/', $fileName);
                $product->image = 'uploads/products/'.$fileName;
            }

            $product->feature = $request->input('feature') == true? '1':'0';
            $product->popular = $request->input('popular')== true? '1':'0';
            $product->status = $request->input('status')== true? '1':'0';
            $product->save();

            return response()->json([
                'status' => 200,
                'message' => 'Product added successfuly'
            ]);
        }
    }


    public function edit($id)
    {
        $product = Product::find($id);

        if($product)
        {
            return response()->json([
                'status' => 200,
                'product' => $product
            ]);

        }else{
            return response()->json([
                'status' => 404,
                'error' => "No product found"
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'category_id' => 'required',
            'slug' => 'required',
            'name' => 'required',
            'brand' => 'required',
            'selling_price' => 'required',
            'original_price' => 'required',
            'qt' => 'required',
            // 'image' => 'required|image|mimes:jpeg,jpg,png',
        ]);


        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ]);
        }
        else
        {
            $product = Product::find($id);
            if($product)
            {

                $product->category_id = $request->input('category_id');
                $product->slug = $request->input('slug');
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->meta_title = $request->input('meta_title');
                $product->meta_keywords = $request->input('meta_keywords');
                $product->meta_description = $request->input('meta_description');
                $product->brand = $request->input('brand');
                $product->qt = $request->input('qt');
                $product->selling_price = $request->input('selling_price');
                $product->original_price = $request->input('original_price');

                if($request->hasFile('image'))
                {
                    $path = $product->image;
                    if(File::exists($path))
                    {
                        File::delete($path);
                    }else{
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $fileName = time() .' . '.$extension;
                        $file->move('uploads/products/', $fileName);
                        $product->image = 'uploads/products/'.$fileName;
                    }
                }
                $product->feature = $request->input('feature') == true? '1':'0';
                $product->popular = $request->input('popular')== true? '1':'0';
                $product->status = $request->input('status')== true? '1':'0';
                $product->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Product updated successfuly'
                ]);
            }

            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product not found'
                ]);  
            }



               
        }

    }
}
