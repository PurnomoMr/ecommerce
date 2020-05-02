<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::latest()->paginate(5);
        
        return view('product.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        //
        $products = Product::all();
        
        return view('product.list',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'pd_name'  => 'required',
            'pd_price' => 'required|integer|min:0',
            'pd_img' =>  'required|image|max:2048'
        ]);

        $image = $request->file('pd_img');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        $form_data = array(
            'pd_name'  =>   $request->pd_name,
            'pd_price' =>   $request->pd_price,
            'pd_img' =>   $new_name
        );
        Product::create($form_data);
   
        return redirect()->route('product.index')
                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        return view('product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $image_name = $request->hidden_image;
        $image = $request->file('pd_img');
        
        if(isset($image) && $image != '')
        {
            $request->validate([
                'pd_name'  => 'required',
                'pd_price' => 'required|integer|min:0',
                'pd_img' =>  'image|max:2048'
            ]);
            
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
        }
        else
        {
            $request->validate([
                'pd_name'  => 'required',
                'pd_price' => 'required|integer|min:0',
            ]);
        }
        
        $form_data = array(
            'pd_name'       =>   $request->pd_name,
            'pd_price'        =>   $request->pd_price
        );

        if(isset($image_name)) {
            $form_data['pd_img'  ] = $image_name;
        }

        $product->update($form_data);
  
        return redirect()->route('product.index')
                        ->with('success','Product updated successfully');$request->validate([
            'pd_name' => 'required',
            'pd_price' => 'required|integer|min:0',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
  
        return redirect()->route('product.index')
                        ->with('success','Product deleted successfully');
    }
}
