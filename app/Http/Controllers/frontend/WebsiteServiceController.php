<?php

namespace App\Http\Controllers\frontend;

use App\Models\FAQ;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsiteServiceController extends Controller
{
    public function index(){
        $data['row'] = Product::with('category')->where('status', 1)->orderByDesc('id')->get();
        return view('frontend.service.index',$data);
    }


    public function details($slug){

        $data['product'] = Product::where('slug', $slug)->with('images')
        ->firstOrFail();
        $data['faqs'] = FAQ::where('status',1)->get();
        return view('frontend.service.details',$data);
    }
    public function CatWiseService($slug)
{

    $category = Category::where('slug', $slug)->firstOrFail();

    $data['row'] = Product::where('category_id', $category->id)
        ->with('images')
        ->get();

    return view('frontend.service.category-wise-service', $data);
}




}
