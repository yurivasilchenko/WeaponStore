<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;


class HomeController extends Controller
{
    public function redirect() {

        if (auth()->check()) {
            $usertype = auth()->user()->usertype;


            if ($usertype == 'admin') {
                return redirect('showorder');
            } else {
                $data = product::paginate('20');

                $user = auth()->user();

                $count = cart::where('email',$user->email)->count();

                return view('user.home',compact('data','count'));
            }
        } else {
            // User is not authenticated, redirect to a default view or show an error message.
            $data = product::paginate('20');


            return view('user.home',compact('data'));
        }

    }


    public function index(){


            return redirect('redirect');

    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $count = 0; // Default count if user is not authenticated

        if (auth()->check()) {
            $user = auth()->user();
            $count = cart::where('email', $user->email)->count();
        }

        return view('user.showproduct', compact('product', 'count'));
    }


    public function search(Request $request){

        $search = $request->search;
        $count = 0; // Default count if user is not authenticated

        if (auth()->check()) {
            $user = auth()->user();
            $count = cart::where('email', $user->email)->count();
        }



        if($search==""){
            $data = product::paginate('12');

            return view('user.home', compact('data'));
        }

        $data = product::where('name','like', '%' . $search . '%')->get();

        return view('user.home',compact('data','count'));

    }


    public function filterProducts(Request $request)
    {
        $type = $request->input('type');

        if($type == 'All'){
            $filteredProducts = Product::paginate(10);
        } else{
            $filteredProducts = Product::where('type', $type)->paginate(10);
        }


        $count = 0; // Default count if user is not authenticated
        if (auth()->check()) {
            $user = auth()->user();
            $count = cart::where('email', $user->email)->count();
        }

        if ($request->ajax()) {
            // Return the partial view with the filtered products
            return response()->view('user.filtered_products_content', ['data' => $filteredProducts, 'count' => $count])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        } else {
            // Return the full view with layout
            return view('user.home', ['data' => $filteredProducts, 'count' => $count]);
        }
    }


    public function addcart(Request $request)
    {

        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();

            $cart = new Cart;

            // Set cart attributes based on user and product data
            $cart->id = $request->id;
            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->product_name = $request->name;
            $cart->type = $request->type;
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
            /*return view('auth.login');*/
        }
    }

    public function showcart()
    {
        if (!auth()->check()) {
            return redirect('redirect');
        }

        $user = auth()->user();
        $cart = cart::where('email', $user->email)->get();
        $count = cart::where('email', $user->email)->count();

        return view('user.showcart', compact('count', 'cart'));
    }

    public function updatecartcount()
    {
        $user = auth()->user();
        $count = Cart::where('email', $user->email)->count();

        return response()->json(['count' => $count]);
    }



    public function deletecart($id){
        $data = cart::find($id);
        $data->delete();

        // Assuming you also want to update the cart count here
        $user = auth()->user();
        $count = cart::where('email', $user->email)->count();

        return response()->json(['success' => true, 'count' => $count]);
    }


    public function order(Request $request){

        $user = auth()->user();



        $name = $user->name;
        $email = $user->email;
        $phone = $user->phone;
        $address = $user->address;

        foreach ($request->product_name as $key => $product_name){

            $order = new Order;

            $order->product_name = $request->product_name[$key];
            $order->type = $request->type[$key];
            $order->price = $request->price[$key];
            $order->quantity = $request->quantity[$key];
            $order->image = $request->image[$key];


            $order->name = $name;
            $order->email = $email;
            $order->phone = $phone;
            $order->address = $address;

            $order->save();


        }

        DB::table('carts')->where('email',$email)->delete();
        return redirect()->back();
    }

}
