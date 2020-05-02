<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartProduct;
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
        $cart = User::select(
            "users.user_name", "users.user_email", "promos.prm_code", "carts.id", "carts.cart_subtotal", "carts.cart_discount",
            "carts.user_id", "carts.cart_total")
            ->join("carts", "users.id", "=", "carts.user_id")
            ->leftJoin("promos", "promos.id", "=", "carts.prm_id")
                ->where("users.id", session()->get('user_id'))->first();
                
        $products = CartProduct::where("cart_id", $cart->id)->get();
        return view("summary", compact('cart', 'products'));
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
        
        $cart = Cart::where("user_id", $user->id)->first(); 
        $data = array(
            "user_id" =>  $user->id
        );
        if(empty($cart->id)) {
            $cart = Cart::create($data);
            $cart = Cart::find($cart->id);
        }
        $cp_total = 0;
        $qty = 0;
        $data['cart_subtotal'] = $cart->cart_total != null ? $cart->cart_total : 0;
        $data['cart_discount'] = $cart->cart_discount != null ? $cart->cart_discount : 0;
        if(isset($request->product) && count($request->product) > 0) {
            $data['cart_subtotal'] = 0;
            foreach ($request->product as $key => $value) {
                # code...
                $product_id = $request->product[$key];
                $qty = $request->qty[$key];

            }
            $product = Product::find($product_id);
            
            if(empty($product->id)) {
                return redirect('/product-list')
                    ->with('error','Product sold out.');
            }
            
            $cp_total = $qty * $product->pd_price;
            $cart_product = array(
                "cart_id" => $cart->id,
                "pd_id" => $product->id,
                "pd_name" => $product->pd_name,
                "pd_price" => $product->pd_price,
                "cp_qty" => $qty,
                "cp_total" => $cp_total
            );
            $latest_cart_product = CartProduct::where(["cart_id" => $cart->id, "pd_id" => $product->id])->first();

            if(empty($latest_cart_product)) {
                CartProduct::create($cart_product);
            } else {
                CartProduct::where("id", $latest_cart_product->id)->update($cart_product);
            }

            $getAllCartProduct = CartProduct::where("cart_id", $cart->id)->get();
            
            foreach ($getAllCartProduct as $keyCP => $valueCP) {
                # code...
                $data['cart_subtotal'] += $valueCP->cp_total;
            }

            if(!empty($cart->prm_id)) {
                $data = $this->sumPromo($data, $cart->prm_id);
            } else {
                $data['cart_discount'] = 0;
            }

            $data['cart_total'] = $data['cart_subtotal'] - $data['cart_discount'];
            Cart::where("id", $cart->id)->update($data);
            return redirect('/product-list')
                ->with('success','Product added to cart.');
        }

        foreach ($request->promo as $key => $value) {
            # code...
            $promo_id = $value;
        }
        
        if(isset($request->promo) && count($request->promo) > 0 && $promo_id != $cart->prm_id){
           $data = $this->sumPromo($data, $promo_id);
        }
        
        $data['cart_total'] = $data['cart_subtotal'] - $data['cart_discount'];
        
        Cart::where("id", $cart->id)->update($data);
        return redirect('/view-cart')
            ->with('error','Promo success to use.');
    }

    protected function sumPromo($data, $promo_id) {
        $promo = Promo::where("id", $promo_id)->first();
            
        if(empty($promo->id)) {
            return redirect('/promo-list')
                ->with('error','Promo can not be use.');
        }
        $data['prm_id'] =  $promo->id;
        $data['cart_discount'] = ceil($data['cart_subtotal'] * $promo->prm_percentage / 100);
        return $data;
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
    public function destroy($id)
    {
        $product = CartProduct::find($id);

        if(empty($cartProduct)) {

        } else {
            
            $cartProduct = CartProduct::join("carts", "carts.cart_id", "=", "cart_products.cart_id")
            ->leftJoin("promos", "promos.id", "=", "carts.prm_id")
                ->where(["carts.cart_id" => $product->cart_id, "carts.user_id" => session()->get('user_id') ])->get();
            CartProduct::where("id", $product->id)->delete();
            $data = [];
            foreach ($cartProduct as $key => $value) {
                # code...
                $data['cart_subtotal'] += $value->cp_total;
            }
        }
        $cartProduct->delete();
  
        return redirect()->route('product.index')
                        ->with('success','Product deleted successfully');
    }
}
