<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function products(){


                return view('admin.products');


    }

    public function uploadproduct(Request $request){

        $data = new Product;



        // Handle single or multiple image uploads
        $images = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('productimages'), $imageName);
                $images[] = $imageName;
            }
        }


        $data->image = json_encode($images);

        $data->name = $request->input('name');
        $data->type = $request->input('type');
        $data->price = $request->input('price');
        $data->quantity = $request->input('quantity');
        $data->description = $request->input('desc');
       /* $data->specs = $request->input('specs'); //this one*/

        $specsArray = $request->input('specs');
        $specsJson = json_encode(array_column($specsArray, 'value', 'key'));

        $data->specs = $specsJson;



        $data->save();

        // Add a success message to the session
        $request->session()->flash('success', 'Product saved successfully');

        return response()->json(['success' => true, 'message' => 'Product saved successfully']);
    }


    public function deleteproduct($id) {
        $data = Product::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $data->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
    }

    public function updateproduct($id){
        $data = Product::find($id);

        return view('admin.updateproduct',compact('data'));

    }

    public function updatedproduct(Request $request,$id){
        $data = Product::find($id);

        // Handle single or multiple image uploads
        $images = json_decode($data->image, true); // Get existing images
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('productimages'), $imageName);
                $images[] = $imageName; // Add new image to the list
            }
            $data->image = json_encode($images); // Update the image field
        }


        $data->image = json_encode($images);


        $data->name = $request->input('name');
        $data->type = $request->input('type');
        $data->price = $request->input('price');
        $data->quantity = $request->input('quantity');
        $data->description = $request->input('desc');
      /*  $data->specs = json_encode($request->input('specs')); //this one*/


        $specsArray = $request->input('specs');
        $specsJson = json_encode(array_column($specsArray, 'value', 'key'));

        $data->specs = $specsJson;


        $data->save();

        // Add a success message to the session

        return redirect('showproducts');

    }

    public function showorder(Request $request){

        $searchQuery = $request->input('query');

        $order = Order::when($searchQuery, function ($query) use ($searchQuery){
            return $query->where('email', 'like', '%' . $searchQuery . '%');
        })->get();

        return view('admin.home', compact('order'));
    }

    public function showproducts(Request $request){

        $searchQuery = $request->input('query');

        $products = product::when($searchQuery, function ($query) use ($searchQuery){
            return $query->where('name' , 'like', '%' . $searchQuery . '%');
        })->get();





        return view('admin.showproducts', compact("products"));
    }

    public function approve($id)
    {
        $order = Order::find($id);
        $order->status = 'Approved';
        $order->save();

        return response()->json(['success' => true]);
    }

    public function disapprove($id)
    {
        $order = Order::find($id);
        $order->status = 'Disapproved';
        $order->save();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $order = Order::find($id);
        $order->delete();

        return response()->json(['success' => true]);
    }





}
