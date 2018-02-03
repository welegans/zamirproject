<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\gender;

class GenderController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth:admin');
    }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $genders = gender::all();
    return view('admin.gender.show',compact('genders'));
  }
  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.gender.index');
  }
  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {

    $this->validate($request,[
      'gender_name' => 'required',
      // 'gender' => 'required',
    ]);

    $gender = new gender;
    $gender->gender_name = $request->gender_name;
    // $gender->gender = $request->gender;
    $gender->save();
    return redirect(route('gender.index'));
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
    $gender = gender::where('id',$id)->first();
    return view('admin.gender.edit',compact('gender'));
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
      'gender_name' => 'required',
      // 'gender' =>'required',
    ]);
    $gender = gender::find($id);
    $gender->gender_name = $request->gender_name;
    // $gender->gender = $request->gender;
    $gender->save();
    return redirect(route('gender.index'));
  }
  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    gender::where('id',$id)->delete();
    return redirect()->back();
  }
}
