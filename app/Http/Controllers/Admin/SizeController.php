<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Size;

class SizeController extends Controller
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
    $sizes = size::all();
    return view('admin.size.show',compact('sizes'));
  }
  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.size.index');
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
      'size' => 'bail|required|unique:sizes|max:255',
      // 'gender' => 'required',
    ]);

    $size = new size;
    $size->size = $request->size;
    // $size->gender = $request->gender;
    $size->save();
    return redirect(route('size.index'));
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
    $size = size::where('id',$id)->first();
    return view('admin.size.edit',compact('size'));
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
      'size' => 'bail|required|unique:sizes|max:255',
      // 'gender' =>'required',
    ]);
    $size = size::find($id);
    $size->size = $request->size;
    // $size->gender = $request->gender;
    $size->save();
    return redirect(route('size.index'));
  }
  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    size::where('id',$id)->delete();
    return redirect()->back();
  }
}
