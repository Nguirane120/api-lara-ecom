<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function placeorder(Request $request)
    {
        if(auth('sanctum')->check())
        {
            $validator = Validator::make($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'address' => 'required',
                'state' => 'required',
                'city' => 'required',
                'zipcode' => 'required',
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
                $order = new Order;
                $user_id = auth('sanctum')->user()->id;
                $order->user_id = $user_id ;
                $order->firstName = $request->firstName;
                $order->lastName = $request->lastName;
                $order->email = $request->email;
                $order->phone = $request->phone;
                $order->address = $request->address;
                $order->state = $request->state;
                $order->city = $request->city;
                $order->zipcode = $request->zipcode;
                $order->city = $request->city;

                $order->payment_mode = 'COD';
                $order->tracking_no = 'nguirane'.rand(1111,9999);
                $order->save();


                $cart = Cart::where('user_id', $user_id)->get();
                $orderItems = [];
                foreach($cart as $item){
                    $orderItems[] = [
                        'product_id' => $item->product_id,
                        'qty' => $item->product_qty,
                        'price' => $item->product->selling_price
                    ];

                    $item->product->update([
                        'qt' => $item->product->qt - $item->product_qty
                    ]);
                }

                $order->orderItem()->createMany($orderItems);
                Cart::destroy($cart);

                return response()->json([
                    'status' => 200,
                    'message' => $request->firstName
                ]);
            }
        }

        else
        {
            return response()->json([
                'status' => 201,
                'message' => "Log in to continue"
            ]);
        }
    }
}
