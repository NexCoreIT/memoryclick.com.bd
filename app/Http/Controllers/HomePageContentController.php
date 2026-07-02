<?php

namespace App\Http\Controllers;

use App\Models\HomePageContent;
use Illuminate\Http\Request;

class HomePageContentController extends Controller
{
    public function index()
    {
        $data['title'] = 'Home Page Index';
        $data['content'] = HomePageContent::get();
        return view('backend.admin.home_page.index', $data);
    }


    public function edit()
    {
        $data['title'] = 'Home Page Edit';
        $data['item'] = HomePageContent::find(1);
        return view('backend.admin.home_page.edit', $data);
    }


    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'homepage_title' => 'nullable|string|max:255',
            'homepage_content' => 'nullable|string',
            'about_title' => 'required|string|max:255',
            'about_content' => 'required|string',
            'home_btn' => 'nullable|string|max:255',
            'about_btn' => 'required|string|max:255',
            'footer_title' => 'required|string|max:255',
            'footer_btn' => 'nullable|string|max:255',
            'messenger_username' => 'nullable',
            'phone' => 'nullable'
        ]);

        $content = HomePageContent::find(1);
        if (!$content) {
            return redirect()->back()->with('error', 'Content not found.');
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/logo/');

            $image->move($uploadPath, $imageName);

            $content->image = 'uploads/logo/' . $imageName;
            $content->save();
        }
        $content->update([
            'homepage_title' => $request->homepage_title,
            'homepage_content' => $request->homepage_content,
            'about_title' => $request->about_title,
            'about_content' => $request->about_content,
            'home_btn' => $request->home_btn,
            'about_btn' => $request->about_btn,
            'footer_title' => $request->footer_title,
            'footer_btn' => $request->footer_btn,
            'youtube_link' => $request->youtube_link,
            'facebook_link' => $request->facebook_link,
            'linkedin_link' => $request->linkedin_link,
            'instagram_link' => $request->instagram_link,
            'twitter_link' => $request->twitter_link,
            'email' => $request->email,
            'address' => $request->address,
            // 'messenger_username' => $request->messenger_username,
            'phone' => $request->phone
            // 'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Content updated successfully.');
    }
}
