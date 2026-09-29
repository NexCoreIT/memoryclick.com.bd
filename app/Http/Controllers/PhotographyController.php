<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Photography;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PhotographyController extends Controller
{
    public function index(){

        $data['title'] = "Photography List";

        $data['photographies'] = Photography::paginate(20);

        return view('backend.admin.photography.index',$data);
    }

    public function create(){

        $data['title'] = "Photography Create";

        $data['categories'] = Category::where('status','1')->get();

        return view('backend.admin.photography.create',$data);
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|max:2048',
        'client_name' => 'required|string|max:255',
        'status' => 'required|boolean',
        'category_id' =>'required',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'package_name' =>'required'
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $uploadPath = public_path('uploads/photography');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $image->move($uploadPath, $imageName);
        $imagePath = 'uploads/photography/' . $imageName;
    }

    // Handle additional images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $imgName = time() . '_' . uniqid() . '_' . $img->getClientOriginalName();
            $img->move($uploadPath, $imgName);
            $additionalImages[] = 'uploads/photography/' . $imgName;
        }
    }

    Photography::create([
        'title' => $request->title,
        'slug' => Str::slug($request->title) . '-' . substr(time(), -4),
        'image' => $imagePath,
        'client_name' => $request->client_name,
        'status' => $request->status,
        'category_id' =>$request->category_id,
        'images' => json_encode($additionalImages),
        'package_name'=>$request->package_name
    ]);

    return redirect()->route('photography.index')->with('success', 'Photography added successfully!');
}


    public function edit($id){

        $data['title'] = "Photography edit";

        $data['photography'] = Photography::find($id);
        $data['categories'] = Category::where('status','1')->get();


        return view('backend.admin.photography.edit',$data);
    }

    public function update(Request $request, $id)
{
    $photography = Photography::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|max:2048',
        'client_name' => 'required|string|max:255',
        'status' => 'required|boolean',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'package_name' => 'required'
    ]);

    $uploadPath = public_path('uploads/photography');

    if ($request->hasFile('image')) {
        if ($photography->image && file_exists(public_path($photography->image))) {
            unlink(public_path($photography->image));
        }

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move($uploadPath, $imageName);
        $photography->image = 'uploads/photography/' . $imageName;
    }

     // Update additional images if uploaded
     if ($request->hasFile('images')) {
        // Delete old additional images
        if ($photography->images) {
            foreach (json_decode($photography->images, true) as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }

        $newImages = [];
        foreach ($request->file('images') as $img) {
            $imgName = time() . '_' . uniqid() . '_' . $img->getClientOriginalName();
            $img->move($uploadPath, $imgName);
            $newImages[] = 'uploads/photography/' . $imgName;
        }
        $photography->images = json_encode($newImages);
    }

    $photography->title = $request->title;
    $photography->slug = Str::slug($request->title);
    $photography->client_name = $request->client_name;
    $photography->status = $request->status;
    $photography->category_id = $request->category_id;
    $photography->package_name = $request->package_name;
    $photography->save();

    return redirect()->route('photography.index')->with('success', 'Photography updated successfully!');
}



public function delete($id)
    {
        try {
            $service = Photography::findOrFail($id);
            $service->delete();

            return redirect()->back()->with('success', 'Photography deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Photography.');
        }
    }
}
