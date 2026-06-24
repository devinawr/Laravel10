<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Transaction;

class FrontEndController extends Controller
{
    public function home() {
        $datas = Service::all();
        return view("home", compact("datas"));
    }

    Public function detail(Request $request, Service $service){
        $data = $service; 
        return view("detail", compact("data"));
    }

    public function putCart(Request $request, Service $service){
        // load cart array
        $cart = $request->session()->get("cart");
        // create a new array if there are no cart yet
        if (!$cart) {
            $cart = array();
        }
        // determine if this is an insert or update operation
        // by finding if the place's id is already in the array
        $idx = -1;
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]["id"] == $service->id) {
            $idx = $i;
            }
        }

        if ($idx < 0) {
            // add new report
            $cart[] = ["id" => $service->id, "quantity" => $request->quantity];
        } else {
            // update existing report
            $cart[$idx]["quantity"] = $request->quantity;
        }
        // save the report array to session
        $request->session()->put("cart", $cart);
        // dd( $request->session()->get("cart")); //remove after this trial
        // redirect to submit page
        return redirect("/cart")->with("status", "Sukses menambah Service yang dibeli");
    }

    public function cart(Request $request){
        // load report array
        $cart = $request->session()->get("cart");
        // create a new array if there are no reports yet
        if (!$cart) {
            $cart = array();
        }
        // load data for each report
        for ($i = 0; $i < count($cart); $i++) {
            $cart[$i]["service"] = Service::find($cart[$i]["id"]);
        }
        // render submit page with all pending cart
        return view("cart", compact("cart"));
    }

    public function deleteCart(Request $request, Service $service){
        // load cart array
        $cart = $request->session()->get("cart");
        // create a new array if there are no cart yet
        if (!$cart) {
            $cart = array();
        }
        // find if the data's id is already in the array
        $idx = -1;
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]["id"] == $service->id) {
            $idx = $i;
            }
        }
        // delete the report
        if ($idx >= 0) {
            array_splice($cart, $idx, 1);
        }
        // save the new array to the session
        $request->session()->put("cart", $cart);
        // redirect to cart page
        return redirect("/cart")->with("status", "Sukses menghapus data");
    }

    function checkout(Request $request){
        // load report array
        $cart = $request->session()->get("cart");
        
        // if there are no reports, don't create new report data
        if (!$cart) {
            return redirect()->back();
        }
        // create new transaction data and save it to create id
        // this is related to the process of filling in the 
        // junction table data
        $transaction = Transaction::createFromCart($cart); 
        
        // attach every items in the array to the transaction data
        foreach ($cart as $r) {
            $transaction->services()->attach($r["id"], ["quantity" => $r["quantity"]]);
        }
        
        // clear data from session after submitting
        $request->session()->forget("cart");
        // redirect to cart page
        return redirect("/cart")->with("status", "Sukses menyimpan data dari cart");
    }

    // public static function createFromCart($data) {
    //     $transaction = new Transaction();
    //     $transaction->user_id = Auth :: user()->id ?? 1;
    //     $transaction->total = Transaction :: calculateTotal($data);
    //     $transaction->save();
    //     return $transaction;
    // }

    // public static function calculateTotal($data)
    // {
    //     $total = 0;
    //     foreach ($data as $item) {
    //         $price = Service :: find($item['id'])->price;
    //         $total += $price * $item['quantity'];
    //     }
    //     return $total;
    // }


}