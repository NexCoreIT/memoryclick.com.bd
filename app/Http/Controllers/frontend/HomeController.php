<?php

namespace App\Http\Controllers\frontend;

use App\Models\Team;
use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Division;
use App\Models\CustomPage;
use App\Models\OurService;
use App\Models\RecentWork;
use App\Models\Photography;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\Cinematography;
use App\Rules\PasswordCheckRule;
use App\Http\Controllers\Controller;
use App\Models\HomePageContent;
use App\Models\Package;
use App\Models\PackageCategory;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Page title
        $data['title'] = 'Home';

        // Static SEO data
        $data['seo'] = [
            'meta_title'       => 'Home',
            'meta_description' => 'Premium wedding photography and cinematography company based in Bangladesh',
            'meta_keywords'    => 'wedding photography, cinematography, bridal shoot, memory click',
        ];

        $data['meta_image'] = HomePageContent::first();


        $data['title'] = 'Home';
        $data['testimonials'] = Testimonial::where('status', '1')->orderByDesc('id')->get();
        $data['service'] = OurService::where('status', '1')->orderBy('id', 'DESC')->get();
        $data['recent_work'] = Photography::where('status', '1')->latest()->take(4)->get();
        $data['cinematography'] = Cinematography::where('status', '1')->get();

        return view('frontend.pages.home', $data);
    }


    public function photography()
    {
        $data['title'] = "Photography";

        $data['categories'] = Category::where('status', '1')->get();

        $data['rows'] = Photography::where('status', '1')->get();

        return view('frontend.photography.index', $data);
    }

    public function photographyDetails($slug){

        $data['title'] = "Top Services";

        $data['row'] = Photography::where('slug', $slug)->firstOrFail();


        return view('frontend.photography.details',$data);
    }


    public function cinematography()
    {

        $data['title'] = 'Cinematography';

        $data['cinematography'] = Cinematography::where('status', '1')->get();

        return view('frontend.cinematography.index', $data);
    }


    public function contactUs()
    {
        $data['title'] = 'Contact';

        return view('frontend.contact.index', $data);
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    public function about()
    {
        $data['title'] = 'About Us';

        $data['page'] = CustomPage::where('slug', 'about-us')->first();
        $data['teams'] = Team::get();

        return view('frontend.about.index', $data);
    }


    public function topService()
    {

        $data['title'] = "All Services";

        $data['service'] = OurService::where('status', '1')->orderBy('id', 'DESC')->get();

        return view('frontend.top_service.index', $data);
    }

    public function topServiceDetails($slug){

        $data['title'] = "Service Details";

        $data['service'] = OurService::where('slug', $slug)->firstOrFail();


        return view('frontend.top_service.details',$data);
    }



    public function package()
    {
        $data['title']      = "Packages";
        $data['divisions']  = Division::active()->latest()->get();
        return view('frontend.package.index', $data);
    }

    public function divisionPackage($slug)
    {
        $data['division'] = Division::where('slug', $slug)->first();

        $packages = Package::with(['features', 'division', 'category'])
            ->active()
            ->where('division_id', $data['division']->id)
            ->latest()
            ->get();
        $data['packagesByCategory'] = $packages->groupBy('category_id');
        $data['categories'] = PackageCategory::active()->latest()->get();
        return view('frontend.package.division_packages', $data);
    }


    public function packageDetails(Request $request)
    {
        $package = Package::with(['features', 'division', 'category'])->findOrFail($request->id);
        return view('frontend.package.package_details', compact('package'));
    }

    public function term()
    {
        $data['title'] = 'Terms and Condition';

        $data['page'] = CustomPage::where('slug', 'terms-and-condition')->first();

        return view('frontend.term.index', $data);
    }

    public function changeProfile()
    {

        return view('frontend.user_dashboard.change-profile');
    }

    public function changePassword()
    {

        return view('frontend.user_dashboard.change-password');
    }


    public function update(Request $request, string $id)
    { {

            $rules = [
                'old_password' => ['required', new PasswordCheckRule], // Check password
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ];

            // Define custom error messages
            $messages = [
                'old_password.required' => 'Old password is required.',
                'new_password.required' => 'New password is required.',
                'new_password.min' => 'New password must be at least 6 characters.',
                'confirm_password.required' => 'Confirm password is required.',
                'confirm_password.same' => 'The new password and confirm password must match.',
            ];

            // Perform the validation
            $validatedData = $request->validate($rules, $messages);

            $userUpdate = User::find($id);


            $userUpdate->update([

                "password" => bcrypt($request->password),


            ]);

            // Update password if a new one is provided
            if ($request->filled('new_password')) {
                $userUpdate->update([
                    'password' => bcrypt($validatedData['new_password']),
                ]);
            }
            return redirect()->back()->withSuccess('Password Update Success');
        }
    }

    public function customerUpdate(Request $request, string $id)
    {

        $userUpdate = User::find($id);


        $imageName = auth()->user()->image;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('uploads', $imageName, 'public');
        }
        //dd($imageName);
        $userUpdate->update([
            "email"   =>  $request->email,
            "phone"   =>  $request->phone,
            "name"    =>  $request->name,
            "role"    =>  'customer',
            "image"   => $imageName,
        ]);



        return redirect()->back()->withSuccess('Profile Update Success');
    }
}
