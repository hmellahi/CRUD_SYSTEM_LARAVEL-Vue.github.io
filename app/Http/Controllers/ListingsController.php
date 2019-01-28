<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\User;
class ListingsController extends Controller
{

    /**
    * Create a new controller instance.
    *
    * @return void
    */

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        //$listings = Listing::all();
        $user_id    = auth()->user()->id; //RIGHT
        $user       = User::find($user_id);
        $listings   = $user->listings;
        return view('listings.index')->with('listings', $listings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // FORM VALIDATE 
        $this->validate($request, [
            "name" => "required",
            "adress" => "required",
            "email" => "required",
            "phone" => "required",
            "bio"   => "required"
        ]);
        // GET THE INTPUTS VALUES INSERT DATA
        $listing = new Listing;
        $listing->name     = $request->input('name');
        $listing->adress   = $request->input('adress');
        $listing->email    = $request->input('email');
        $listing->phone    = $request->input('phone');
        $listing->bio      = $request->input('bio');
        $listing->website  = $request->input('website');
        $listing->user_id  = auth()->user()->id;
        $listing->save();
        // REDIRECT TO THE HOME PAGE
        return redirect('/listings')->with('success',"The listing has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // FIND THE LISTING BY HIS ID
        $listing = Listing::find($id);
        return view('listings.show')->with('listing', $listing);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // FIND THE LISTING BY HIS ID
        $listing = Listing::find($id);
        return view('listings.edit')->with('listing', $listing);
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
        // FORM VALIDATE 
        $this->validate($request, [
            "name" => "required",
            "adress" => "required",
            "email" => "required",
            "phone" => "required",
            "bio"   => "required"
        ]);
        // GET THE INTPUTS VALUES THEN UPDATE DATA
        $listing = Listing::find($id);
        $listing->name     = $request->input('name');
        $listing->adress   = $request->input('adress');
        $listing->email    = $request->input('email');
        $listing->phone    = $request->input('phone');
        $listing->bio      = $request->input('bio');
        $listing->website  = $request->input('website');
        $listing->user_id  = auth()->user()->id;
        $listing->save();
        // REDIRECT TO THE HOME PAGE
        return redirect('/listings')->with('success',"The listing has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // FIND THE LISTING BY HIS ID
        $listing = Listing::find($id);
        // DELETE LISTING FROM DATABASE
        $listing->delete();
        // REDIRECT TO HOME PAGE
        return view('listings.index')->with('success', "The listing has been deleted");
    }

}
