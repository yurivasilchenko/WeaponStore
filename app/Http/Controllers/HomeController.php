<?php

namespace App\Http\Controllers;

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
}
