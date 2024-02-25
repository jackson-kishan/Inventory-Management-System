<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    
    public function ProductPage(){
        return view('pages.dashboard.product-page');
    }

    public function CreateProduct(Request $request) {
         $user_id = $request->header('id');

         //prepare file name and path
         $img = $request->file('img');
         
         $t = time();
         $file_name = $img->getClientOriginalName();
         $img_name = "{$user_id}-{$t}-{$file_name}";
         $img_url = "uploads/{$img_name}";

         $img->move(public_path('uploads'), $img_name);

         return Product::create([
           'name' => $request->input('name'),
           'price' => $request->input('price'),
           'unit' => $request->input('unit'),
           'img_url' => $img_url,
           'category_id' => $request->input('category_id'),
           'user_id' => $user_id
         ]);

    }

    public function DeleteProduct(Request $request) {
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        $filePath = $request->input('file_path');
        File::delete($filePath);  
        return Product::where('id', $product_id)->where('user_id', $user_id)->delete();
    }

    public function ProductByID(Request $request) {
      $user_id = $request->header('id');
      $product_id = $request->input('id');
      return Product::where('id', $product_id)->where('user_id', $user_id)->first();
    }

    public function ProductList(Request $request) {
      $user_id = $request->header('id');
      return Product::where('user_id', $user_id)->get();
    }

    public function UpdateProduct(Request $request) {
      $user_id = $request->header('id');
      $product_id = $request->input('id');

      if($request->hasFile('img')) {

        //Update new Product
        $img = $request->file('img');
        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$t}-{$file_name}";
        $img_url = "uploads/{$img_name}";

         $img->move(public_path('uploads'), $img_name);

         //delete old image
         $filePath = $request->input('file_path');
         File::delete($filePath);

         return Product::where('id', $product_id)->where('user_id', $user_id)->update([
          'name' => $request->input('name'),
          'price' => $request->input('price'),
          'unit' => $request->input('unit'),
          'img_url' => $img_url,
          'category_id' => $request->input('category_id'),
         ]);

      } else {

        return Product::where('id', $product_id)->where('user_id', $user_id)->update([
          'name' => $request->input('name'),
          'price' => $request->input('price'),
          'unit' => $request->input('unit'),
          'category_id' => $request->input('category_id'),

        ]);
      } 

    }
}



