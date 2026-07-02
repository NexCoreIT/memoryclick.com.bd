<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(){

        $data['title'] = "Service List";

        $data['testimonials'] = Testimonial::get();

        return view('backend.admin.testimonial.index',$data);
    }

    public function create(){

        $data['title'] = "Service Create";

        return view('backend.admin.testimonial.create',$data);
    }

    public function store(Request $request)
{
    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|boolean',
         'rating' => 'required|numeric|min:1|max:5'
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName(); // keep original name
        $uploadPath = public_path('uploads/testimonial');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true); // use PHP mkdir instead of File facade
        }

        $image->move($uploadPath, $imageName);
        $imagePath = 'uploads/testimonial/' . $imageName;
    }


    Testimonial::create([
        'rating' =>$request->rating,
        'name' => $request->name,
        'description' => $request->description,
        'status' => $request->status,
        'image' => $imagePath,
        'designation'=> $request->designation,
    ]);

    return redirect()->route('testimonial.index')->with('success', 'Testimonial created successfully!');
}

    public function edit($id){

        $data['title'] = "Testimonial edit";

        $data['testimonial'] = Testimonial::find($id);

        return view('backend.admin.testimonial.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'rating' => 'required|numeric|min:1|max:5',
            'designation' => 'required',
        ]);

        $testimonial = Testimonial::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                unlink(public_path($testimonial->image));
            }

            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $uploadPath = public_path('uploads/testimonial');

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image->move($uploadPath, $imageName);
            $testimonial->image = 'uploads/testimonial/' . $imageName;
        }

        $testimonial->update([
        'rating' =>$request->rating,
        'name' => $request->name,
        'description' => $request->description,
        'status' => $request->status,
        'designation'=> $request->designation,
        ]);

        return redirect()->route('testimonial.index')->with('success', 'Testimonial updated successfully!');
    }

    public function delete($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Delete image if exists
        if ($testimonial->image && file_exists(public_path($testimonial->image))) {
            unlink(public_path($testimonial->image));
        }

        $testimonial->delete();

        return redirect()->route('testimonial.index')->with('success', 'Testimonial deleted successfully!');
    }
}
