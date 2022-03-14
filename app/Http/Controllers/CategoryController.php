<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 200,
            'categories' => $categories
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meta_title' => 'required',
            'slug' => 'required',
            'name' => 'required',
            
        ]);


        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        }else{
            $category = new Category();
            $category->meta_title = $request->input('meta_title');
            $category->meta_keywords = $request->input('meta_keywords');
            $category->meta_description = $request->input('meta_description');
            $category->slug = $request->input('slug');
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->status = $request->input('status') == true ? '1' : '0';
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category added successfully'
            ]);
        }


    }
    public function edit($id)
    {
        $category = Category::find($id);
        if($category)
        {

        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
        }else{

          return response()->json([
            'status' => 404,
            'message' => 'No category id found'
        ]);
        }
    }


    public function update(Request $request,  $id)
    {
        $validator = Validator::make($request->all(), [
            'meta_title' => 'required',
            'slug' => 'required',
            'name' => 'required',
            
        ]);


        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ]);
        }else{
            $category = Category::find($id);
            $category->meta_title = $request->input('meta_title');
            $category->meta_keywords = $request->input('meta_keywords');
            $category->meta_description = $request->input('meta_description');
            $category->slug = $request->input('slug');
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->status = $request->input('status') == true ? '1' : '0';
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category updated successfully'
            ]);
        }

    }


    public function destroy($id)
    {
        $category = Category::find($id);

        if($category)
        {
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully'
            ]);
        }
    }
}
