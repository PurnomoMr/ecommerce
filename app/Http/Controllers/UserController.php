<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('ecommerce');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user');
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
            'user_name'  => 'required',
            'user_email' => 'required|email',
        ]);

        $user = User::where('user_email', $request->user_email)->get();
        if(empty($user[0]->id)) {
            $latest_user = User::create($request->all());
            
            session()->put('user_name', $request->user_name);
            session()->put('user_id', $latest_user->id);
            return redirect("/product-list")
                            ->with('success','User created successfully. Please choose your products.');
        } else {
            session()->put('user_name', $user[0]->user_name);
            session()->put('user_id', $user[0]->id);
            return redirect('/product-list')
                            ->with('success','Welcome back '.$user[0]->user_name.', Please choose your products.');
        }
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
