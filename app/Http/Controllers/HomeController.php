<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;


class HomeController extends Controller
{
    public function redirect() {

        if (auth()->check()) {
            $usertype = auth()->user()->usertype;


            if ($usertype == 'admin') {
                return view('admin.home');
            } else {
                $data = product::paginate('6');
                return view('user.home',compact('data'));
            }
        } else {
            // User is not authenticated, redirect to a default view or show an error message.
            $data = product::paginate('6');
            return view('user.home',compact('data'));
        }

    }


    public function index(){

        if(Auth::id()){
            return redirect('redirect');
        }
        else{
            $data = product::paginate('6');

            return view('user.home', compact('data'));
        }
    }

    public function search(Request $request){

        $search = $request->search;

        if($search==""){
            $data = product::paginate('6');

            return view('user.home', compact('data'));
        }

        $data = product::where('name','like', '%' . $search . '%')->get();

        return view('user.home',compact('data'));

    }

    public function addcart(Request $request)
    {

        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();

            $cart = new Cart;

            // Set cart attributes based on user and product data
            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->product_name = $request->name;
            $cart->price = $request->price;
            $cart->quantity = $request->quantity;
            $cart->description = $request->description;
            $cart->image = $request->image;

            $cart->save();

            // Return a JSON response indicating success
            return response()->json(['success' => true]);
        } else {
            // If the user is not authenticated, return a JSON response indicating failure
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }
    }




}
