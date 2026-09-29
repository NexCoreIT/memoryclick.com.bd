<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PackageFeature;
use App\Models\PackageCategory;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    public function index()
    {
        $data['title']      = 'Packages List';
        $data['packages']   = Package::with(['division', 'category'])->paginate(20);
        return view('backend.admin.package.index', $data);
    }

    public function create()
    {
        $data['title']      = 'Packages Create';
        $data['divisions'] = Division::active()->latest()->get();
        $data['categories'] = PackageCategory::active()->latest()->get();
        return view('backend.admin.package.create', $data);
    }


    public function store(Request $request)
    {

        $request->validate([
            'package_name'  => 'required',
            'division_id'   => 'required',
            'category_id'   => 'required',
            'price'         => 'required',
            'image'         => 'required',
            'features'      => 'nullable',
            'number_of_photos'   => 'required',
        ]);

        try {
            $data                       = new Package();
            $data->package_name         = $request->package_name;
            $data->slug                 = Str::slug($request->package_name);
            $data->division_id          = $request->division_id;
            $data->category_id          = $request->category_id;
            $data->price                = $request->price;
            $data->chief                = $request->chief;
            $data->photographer         = $request->photographer;
            $data->cinematographer      = $request->cinematographer;
            $data->number_of_photos     = $request->number_of_photos;
            $data->description          = $request->description;

            $data->status               = $request->status;
            if ($request->hasFile('image')) {
                $image          = $request->file('image');
                $imageName      = $image->getClientOriginalName();
                $uploadPath     = public_path('uploads');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $image->move($uploadPath, $imageName);
                $imagePath = 'uploads/' . $imageName;
                $data->image = $imagePath;
            }
            $data->save();
            //  features
            if ($request->has('features')) {
                foreach ($request->features as $feature) {
                    if (!empty($feature)) {
                        $item = new PackageFeature;
                        $item->package_id = $data->id;
                        $item->name = $feature;
                        $item->save();
                    }
                }
            }
            return redirect()->route('package.index')->with('success', 'Package created successfully!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function edit($id)
    {
        $data['title']      = 'Edit Packages';
        $data['divisions']  = Division::active()->latest()->get();
        $data['categories'] = PackageCategory::active()->latest()->get();
        $data['package']    = Package::findOrFail($id);
        return view('backend.admin.package.edit', $data);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'package_name'  => 'required',
            'division_id'   => 'required',
            'category_id'   => 'required',
            'price'         => 'required',
            'features'      => 'nullable',
            'number_of_photos'      => 'required',
        ]);

        try {
            $data                       = Package::findOrFail($id);
            $data->package_name         = $request->package_name;
            $data->slug                 = Str::slug($request->package_name);
            $data->division_id          = $request->division_id;
            $data->category_id          = $request->category_id;
            $data->price                = $request->price;
            $data->chief                = $request->chief;
            $data->photographer         = $request->photographer;
            $data->cinematographer      = $request->cinematographer;
            $data->number_of_photos     = $request->number_of_photos;
            $data->description          = $request->description;
            $data->status               = $request->status;
            if ($request->hasFile('image')) {
                if ($data->image) {
                    $image_path = public_path($data->image);
                    if (file_exists($image_path)) {
                        File::delete($image_path);
                    }
                }

                $image          = $request->file('image');
                $imageName      = $image->getClientOriginalName();
                $uploadPath     = public_path('uploads/slider');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $image->move($uploadPath, $imageName);
                $imagePath = 'uploads/slider/' . $imageName;
                $data->image = $imagePath;
            }
            $data->update();
            //  features
            if ($request->has('features')) {
                PackageFeature::where('package_id', $id)->delete();
                foreach ($request->features as $feature) {
                    if (!empty($feature)) {
                        $item = new PackageFeature();
                        $item->package_id = $data->id;
                        $item->name = $feature;
                        $item->save();
                    }
                }
            }
            return redirect()->route('package.index')->with('success', 'Package updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function view($id)
    {
        $data['title']      = 'View Packages';
        $data['package']    = Package::findOrFail($id);
        return view('backend.admin.package.view', $data);
    }


    public function delete($id)
    {
        try {
            $package = Package::findOrFail($id);
            $package->features()->delete();
            if ($package->image) {
                if ($package->image) {
                    $image_path = public_path($package->image);
                    if (file_exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
            $package->delete();

            return redirect()->route('package.index')->with('success', 'Package deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
