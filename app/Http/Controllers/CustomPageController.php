<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CustomPageController extends Controller
{
    public function index()
    {
        $data = CustomPage::all();
        return view('backend.admin.custom_page.index', compact('data'));
    }

    public function edit($id)
    {
        $item = CustomPage::findOrFail($id);
        return view('backend.admin.custom_page.edit', compact('item'));
    }

//     public function update(Request $request, $id)
// {

//     // dd($request->all());
//     // Validate the incoming request data
//     $validatedData = $request->validate([
//         'title' => 'required|string|max:255',
//         'slug' => 'nullable|string|max:255', // Optional; will generate if not provided
//         'meta_title' => 'required|string|max:255',
//         'meta_description' => 'required|string|max:255',
//         'meta_keywords' => 'required|string|max:255',
//         'status' => 'required|boolean',
//         'body' => 'required',
//     ]);

//     // Find the existing record
//     $item = CustomPage::findOrFail($id);

//     // Assign each field explicitly
//     $item->title = $validatedData['title'];
//     $item->meta_title = $validatedData['meta_title'];
//     $item->meta_description = $validatedData['meta_description'];
//     $item->meta_keywords = $validatedData['meta_keywords'];
//     $item->status = $validatedData['status'];
//     $item->body = $validatedData['body'];

//     // Save the updated record
//     $item->save();

//     // Redirect or return response
//     return redirect()->route('custom.page.index')->with('success', 'Custom page updated successfully.');
// }

public function update(Request $request, $id)
{
    // Find the existing record
    $item = CustomPage::findOrFail($id);

    // Validate inputs
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255|unique:custompages,slug,' . $id,
        'meta_title' => 'required|string|max:255',
        'meta_description' => 'required|string|max:255',
        'meta_keywords' => 'required|string|max:255',
        'status' => 'required|boolean',
        'body' => 'nullable',
        'about_memoryclick' => 'nullable|string',
        'ceo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'memoryclick_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
              'ceo_name' => 'nullable|string|max:255',
        'ceo_designation' => 'nullable|string|max:255',
        'title_1' => 'nullable|string|max:255',
        'title_2' => 'nullable|string|max:255',
    ]);

    // Assign common fields
    $item->title = $validatedData['title'];
    $item->meta_title = $validatedData['meta_title'];
    $item->meta_description = $validatedData['meta_description'];
    $item->meta_keywords = $validatedData['meta_keywords'];
    $item->status = $validatedData['status'];
    $item->body = $validatedData['body'];
    $item->title_1 = $validatedData['title_1'] ?? $item->title_1;
    $item->title_2 = $validatedData['title_2'] ?? $item->title_2;



    // Extra fields only for id == 1
    if ($item->id == 1) {
        // $item->about_ceo = $validatedData['about_ceo'] ?? $item->about_ceo;
        $item->about_memoryclick = $validatedData['about_memoryclick'] ?? $item->about_memoryclick;
        $item->ceo_name = $validatedData['ceo_name'] ?? $item->ceo_name;
        $item->ceo_designation = $validatedData['ceo_designation'] ?? $item->ceo_designation;

        // CEO Image Upload
        if ($request->hasFile('ceo_image')) {
            $ceoImage = $request->file('ceo_image');
            $ceoImageName = 'ceo_' . time() . '.' . $ceoImage->getClientOriginalExtension();
            $path = public_path('uploads/custompages/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $ceoImage->move($path, $ceoImageName);
            $item->ceo_image = 'uploads/custompages/' . $ceoImageName;
        }

        // Memoryclick Image Upload
        if ($request->hasFile('memoryclick_image')) {
            $memoryImage = $request->file('memoryclick_image');
            $memoryImageName = 'memoryclick_' . time() . '.' . $memoryImage->getClientOriginalExtension();
            $path = public_path('uploads/custompages/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $memoryImage->move($path, $memoryImageName);
            $item->memoryclick_image = 'uploads/custompages/' . $memoryImageName;
        }
    }

    // Save the updated record
    $item->save();

    // Redirect with success message
    return redirect()->route('custom.page.index')->with('success', 'Custom page updated successfully.');
}




public function about(){
    return view('frontend.custom_page.about');
}
}
