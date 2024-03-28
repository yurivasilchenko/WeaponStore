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

        $data->save();

        // Add a success message to the session
        $request->session()->flash('success', 'Product saved successfully');

        return response()->json(['success' => true, 'message' => 'Product saved successfully']);
    }

    public function showproducts(){
        $data = product::all();
        return view('admin.showproducts', compact("data"));
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


        $data->save();

        // Add a success message to the session

        return redirect('showproducts');

    }

    public function showorder(){

        $order = order::all();
        return view('admin.home',compact('order'));
    }

}
