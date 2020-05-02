<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Promo;
use App\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $user_id = session()->get("user_id");
        $user = User::find($user_id);
        if(session()->get("user_id") == null && empty($user->id)) {
            return redirect("/user")
                ->with('error','Please fill your data.');
        }
        
        // //
        $request->validate([
            'product[]'  => 'integer|min:1',
            'qty[]'  => 'integer|min:1',
            'promo[]'  => 'integer|min:1'
        ]);
        
        $cart = Cart::where("user_id", $user->id)->get(); 
        $data = array(
            "user_id" =>  $user->id
        );
        if(empty($cart->id)) {
            $cart = Cart::create($data);
            $cart = Cart::find($cart->id);
        }
        $cp_total = 0;
        $qty = 0;
        if(isset($request->product) && count($request->product) > 0) {
            foreach ($request->product as $key => $value) {
                # code...
                $product_id = $request->product[$key];
                $qty = $request->qty[$key];

            }
            $product = Product::where("id", $product_id)->get();
            
            if(empty($product->id)) {
                return redirect('/product-list')
                    ->with('error','Product sold out.');
            }
            $cp_total = $qty * $product->pd_price;
            $cart_product = array(
                "cart_id" => $cart->id,
                "pd_id" => $product->id,
                "pd_name" => $product->pd_name,
                "cp_qty" => $request->qty,
                "cp_total" => $cp_total
            );
            Product::create($cart_product);
            
            $data['cart_subtotal'] = $cart->cart_total != null ? $cart->cart_total + $cp_total : 0 + $cp_total;
            $data['cart_discount'] = $cart->cart_discount != null ? $cart->cart_discount : 0;
            Cart::where("id", $cart->id)->update($data);
            return redirect('/promo-list')
                ->with('error','Product sold out.');
        }

        $data['cart_subtotal'] = $cart->cart_total != null ? $cart->cart_total + $cp_total : 0 + $cp_total;
        $data['cart_discount'] = $cart->cart_discount != null ? $cart->cart_discount : 0;
        foreach ($request->promo as $key => $value) {
            # code...
            $promo_id = $value;
        }
        if(isset($request->promo) && count($request->promo) > 0 && $promo_id != $cart->prm_id){
            $promo = Promo::whereIn("id", $promo_id)->get();

            if(empty($promo->id)) {
                return redirect('/promo-list')
                    ->with('error','Promo can not be use.');
            }
            $data['prm_id'] =  $promo->prm_id;
            $data['cart_discount'] = ($data['cart_subtotal'] * $promo->prm_percetage) / 100;
        }
        
        $data['cart_total'] = $data['cart_subtotal'] - $data['cart_discount'];

        Cart::where("id", $cart->id)->update($data);
        return redirect('/promo-list')
            ->with('error','Product sold out.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
