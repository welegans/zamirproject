<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Size;
use Validator;

class ProductController extends Controller
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
    $categories =category::all();
    $products = product::all();
    return view('admin.product.show',compact('categories','products'));
    //
    // return view('products');
    //  $categories =  Category::pluck('category_name', 'id');
    //  return view('products',compact(['categories']));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $sizes =size::all();
    $categories =category::all();
    return view('admin.product.index',compact('categories','sizes'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //dd($request->all());
    $this->validate($request,[
      'title'=>'bail|required|max:255',
      'subtitle' => 'required',
      'description' => 'required|max:512',
      'oldprice' => 'required|size:10|numeric',
      'price' => 'required|size:10|numeric',
      'gender'=> 'required',
      'uimage' => 'required|array|min:1|max:5|mimes:jpeg,jpg,png'
    ]);

    $imagesArray = array();//imp dont delete

    foreach ($request->uimage as $value) {

      $file_name = 'img_'.microtime().'.png'; //generating unique file name;
      @list($type, $value) = explode(';', $value);
      @list(, $value) = explode(',', $value);
      if($value!=""){ // storing image in storage/app/public Folder
        //dd($value);
        //base64_decode($value)->store('public');
        $isInserted =  \Storage::disk('images')->put($file_name,base64_decode($value));
        if($isInserted){
          array_push($imagesArray,$file_name);
        }
      }

    }
    if ($request->hasFile('image')) {
      $imageName = $request->image->store('public');

    }else{
      // return 'No';
    }

    $products = new Product;
    $products->image = implode(',', $imagesArray);
    $products->title = $request->title;
    $products->subtitle = $request->subtitle;
    $products->description = $request->description;
    $products->oldprice = $request->oldprice;
    $products->price = $request->price;
    $products->brand = $request->brand;
    $products->status = $request->status;
    $products->gender = $request->input('gender');
    $products->save();
    $products->sizes()->sync($request->sizes);
    $products->categories()->sync($request->categories);

    return redirect(route('products.index'));
  }
  public function imagesUploadPost(Request $request)

  {
    request()->validate([
      'image' => 'required',
    ]);
    foreach ($request->file('image') as $key => $value) {
      $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
      $value->move(public_path('images'), $imageName);
    }
    return response()->json(['success'=>'Images Uploaded Successfully.']);
  }
  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show()
  {
    $url = Storage::url('test.jpg');
    return "<img src='".$url."'/>";
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    // $category = category::where('id',$id)->first();
    $sizes =size::all();
    $categories =category::all();
    $product = product::with('categories')->where('id',$id)->first();
    // dd($product->gender);
    return view('admin.product.edit',compact('categories','product','sizes'));
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
    //dd($request->all());
    $this->validate($request,[
      'title'=>'bail|required|max:255',
      'subtitle' => 'required',
      'description' => 'required|max:512',
      'oldprice' => 'required|size:10|numeric',
      'price' => 'required|size:10|numeric',
      'gender'=> 'required'
    ]);

    if(!$request->has('oldImage')){
      $request->oldImage = [];
    }
    if(!$request->has('uimage')){
      $request->uimage = [];
    }
    $combinedImages = ["Image"=>array_merge($request->uimage, $request->oldImage)];
    $validator = Validator::make($combinedImages,[
      'Image'=>'required|array|min:1|max:5|mimes:jpeg,jpg,png'
    ]);

    if ($validator->fails()) {
      return back()
      ->withErrors($validator)
      ->withInput();
    }


    $imagesArray = array();//imp dont delete
    if($request->has('oldImage')){
      foreach ($request->oldImage as $urlImage) {
        array_push($imagesArray, basename($urlImage));
      };
    };

    if($request->has('uimage')){
      foreach ($request->uimage as $value) {
        $file_name = 'img_'.microtime().'.png'; //generating unique file name;
        @list($type, $value) = explode(';', $value);
        @list(, $value) = explode(',', $value);
        if($value!=""){ // storing image in storage/app/public Folder
          //dd($value);
          //base64_decode($value)->store('public');
          $isInserted =  \Storage::disk('images')->put($file_name,base64_decode($value));
          if($isInserted){
            array_push($imagesArray,$file_name);
          }
        }
      };
    };


    //dd(implode(',', $imagesArray));

    if ($request->hasFile('image')) {
      // $request->file('image');
      // return $request->image->storeAs('public','test.jpg');
      // $imageGet=$request->image->getClientOriginalName();
      //$imageName = $request->image->store('public');

    }else{
      //return 'No file';
    }

    $products = product::find($id);
    $products->image = implode(',', $imagesArray);
    // $products->image = $imageGet;
    $products->title = $request->title;
    $products->subtitle = $request->subtitle;
    $products->description = $request->description;
    $products->oldprice = $request->oldprice;
    $products->price = $request->price;
    $products->brand = $request->brand;
    $products->status = $request->status;
    $products->gender = $request->input('gender');
    // dd($products->gender);
    $products->sizes()->sync($request->sizes);
    $products->categories()->sync($request->categories);

    $products->save();

    return redirect(route('products.index'));
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    product::where('id',$id)->delete();
    return redirect()->back();
  }
}
