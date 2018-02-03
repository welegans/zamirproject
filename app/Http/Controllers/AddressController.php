<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
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
    // dd($request->all());

    $this->validate($request,[
      'address'=>'required|max:255',
      'city'=>'required|max:255',
      'state'=>'required|max:255',
      'zip'=>'required|integer|max:255',
      'phone'=>'required|regex:/^[0-9\-\+]{9,15}$/',
    ]);

    Auth::user()->address()->create($request->all());
    return redirect()->back();
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
    $address = address::where('id',$id)->first();
    return view('admin.address.edit',compact('address'));
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
    $this->validate($request,[
      'address'=>'required|max:255',
      'city'=>'required|max:255',
      'state'=>'required|max:255',
      'zip'=>'required|integer|max:255',
      'phone'=>'required|regex:/^[0-9\-\+]{9,15}$/',
    ]);

    $addreses = Address::find($id);
    $addreses->address = $request->address;
    $addreses->city = $request->city;
    $addreses->state = $request->state;
    $addreses->zip = $request->zip;
    $addreses->phone = $request->phone;
    $addreses->country = $request->country;
    $addreses->save();
      // return redirect(route('profile'));
      return redirect()->back();

  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    address::where('id',$id)->delete();
    return redirect()->back();
  }

  public function updateAddress(Request $request)
  {
    $this->validate($request,[
      'address'=>'required',
      'city'=>'required',
      'state'=>'required',
      'zip'=>'required|integer',
      'phone'=>'required|regex:/^[0-9\-\+]{9,15}$/',
    ]);

    $id = $request->id;
    $addreses = Address::find($id);
    $user_id = Auth::user()->id;

    if($user_id == $addreses->user_id){
      $addreses->address = $request->address;
      $addreses->city = $request->city;
      $addreses->state = $request->state;
      $addreses->zip = $request->zip;
      $addreses->phone = $request->phone;
      $addreses->country = $request->country;
      $addreses->save();
    }
    return Redirect()->back();
    // return redirect()->route('profile');
  }
}
