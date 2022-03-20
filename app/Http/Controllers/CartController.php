<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addTocart(Request $request)
    {
      

       if(auth('sanctum')->check())
       {
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $product_qty = $request->product_qty;
            $productChecked = Product::where('id', $product_id)->first();
            if($productChecked)
            {
                    if(Cart::where('product_id', $product_id)->where('user_id', $user_id)->exists())
                    {
                        return response()->json([
                            'status' => 409,
                            'message' => $productChecked->name.' Alrady added'
                        ]);
                    }
                    else
                    {
                        $cartItem = new Cart();
                        $cartItem->user_id = $user_id;
                        $cartItem->product_id = $product_id;
                        $cartItem->product_qty = $product_qty;
                        $cartItem->save();

                    }
                return response()->json([
                    'status' => 201,
                    'message' => $productChecked->name." added successfuly"
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
       else
       {
        return response()->json([
            'status' => 401,
            'message' => "login first to add cart"
        ]); 
       }
    }

    public function getCart()
    {
        if(auth('sanctum')->check())
        {
            $user_id = auth('sanctum')->user()->id;

            $cartItems = Cart::where('user_id', $user_id)->get();
            return response()->json([
                'status' => 200,
                'cart' => $cartItems
            ]);
        }

        else{
            return response()->json([
                'status' => 401,
                'message' => 'Login to view your cart'
            ]);
        }
    }
}
