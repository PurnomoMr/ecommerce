<?php

namespace App\Http\Controllers;

use App\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $promos = Promo::latest()->paginate(5);
        // var_dump($product);exit();
        return view('promo.index',compact('promos'))
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
        $promos = Promo::all();
        
        return view('promo.list',compact('promos'))
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
        return view('promo.create');
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
            'prm_code'  => 'required',
            'prm_percentage' => 'required|integer|min:1|max:100',
        ]);

        Promo::create($request->all());
   
        return redirect()->route('promo.index')
                        ->with('success','Promo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function show(Promo $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function edit(Promo $promo)
    {
        //
        return view('promo.edit',compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promo $promo)
    {
        //
        $request->validate([
            'prm_code'  => 'required',
            'prm_percentage' => 'required|integer|min:1|max:100',
        ]);

        $promo->update($request->all());

        return redirect()->route('promo.index')
                        ->with('success','Product updated successfully');$request->validate([
                            'prm_code'  => 'required',
                            'prm_percentage' => 'required|integer|min:1|max:100',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promo $promo)
    {
        //
        $promo->delete();
  
        return redirect()->route('promo.index')
                        ->with('success','Promo deleted successfully');
    }
}
