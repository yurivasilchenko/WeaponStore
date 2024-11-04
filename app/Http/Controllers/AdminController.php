<?php

namespace App\Http\Controllers;

use App\Models\Message;
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

    public function updatedproduct(Request $request, $id)
    {
        $data = Product::find($id);

        // Handle the image update logic
        if ($request->hasFile('files')) {
            // Delete old images from the server
            $oldImages = json_decode($data->image, true);
            if (!empty($oldImages)) {
                foreach ($oldImages as $oldImage) {
                    $oldImagePath = public_path('productimages/' . $oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Delete old image file
                    }
                }
            }

            // Process new images
            $images = [];
            foreach ($request->file('files') as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('productimages'), $imageName);
                $images[] = $imageName; // Add new image to the array
            }
            $data->image = json_encode($images); // Update the image field with new images
        }

        // Update other product fields
        $data->name = $request->input('name');
        $data->type = $request->input('type');
        $data->price = $request->input('price');
        $data->quantity = $request->input('quantity');
        $data->description = $request->input('desc');

        // Update the specs
        $specsArray = $request->input('specs');
        $specsJson = json_encode(array_column($specsArray, 'value', 'key'));
        $data->specs = $specsJson;

        // Save the updated product data
        $data->save();

        // Redirect with success message
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



    public function adminchat($userId = null)
    {
        $adminId = Auth::id();  // Assuming admin is the authenticated user
        $users = \App\Models\User::where('usertype', 'user')->get();

        if ($userId) {
            // Fetch only messages between admin and the selected user
            $messages = Message::where(function ($query) use ($adminId, $userId) {
                $query->where('sender_id', $adminId)->where('recipient_id', $userId)
                    ->orWhere('sender_id', $userId)->where('recipient_id', $adminId);
            })->get();
        } else {
            // No messages will be shown initially before a user is selected
            $messages = collect();  // Empty collection
        }

        if (request()->ajax()) {
            // If the request is AJAX, return only the messages view
            return view('components.messages', ['messages' => $messages])->render();
        }

        return view('admin.chat', ['messages' => $messages, 'users' => $users]);
    }

}
