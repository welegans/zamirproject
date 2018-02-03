<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
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
    $categories = category::all();
    return view('admin.category.show',compact('categories'));
  }
  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.category.index');
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
      'category_name' => 'bail|required|unique:categories|max:255',
      'catimage' => 'required|image|mimes:jpg,png',
    ]);
    if ($request->hasFile('catimage')) {
                $imageName = $request->catimage->store('images');
            }else{
                return 'No';
            }
    $category = new category;
    $category->catimage = $imageName;
    $category->category_name = $request->category_name;
    // $category->gender = $request->gender;
    $category->save();
    return redirect(route('category.index'));
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
    $category = category::where('id',$id)->first();
    return view('admin.category.edit',compact('category'));
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
      'category_name' => 'bail|required|max:255',
      'catimage' => 'required|image|mimes:jpg,png',
    ]);
    if ($request->hasFile('catimage')) {
              //$imageName =   \Storage::disk('categories')->putFile($request->file('catimage'));
                $imageName = $request->catimage->store('','categories');
            }else{
                return 'No';
            }
    $category = category::find($id);
      $category->catimage = $imageName;
    $category->category_name = $request->category_name;
    // $category->gender = $request->gender;
    $category->save();
    return redirect(route('category.index'));
  }
  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    category::where('id',$id)->delete();
    return redirect()->back();
  }
}
