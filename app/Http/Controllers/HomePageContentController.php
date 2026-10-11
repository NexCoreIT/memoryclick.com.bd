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
            'phone' => 'nullable',
            'since_year' => 'nullable|string|max:255',
            'events_count' => 'nullable|string|max:255',
            'photos_count' => 'nullable|string|max:255',
            'clients_count' => 'nullable|string|max:255',
            'service_subtitle' => 'nullable|string|max:255',
            'service_title' => 'nullable|string|max:255',
            'recent_work_subtitle' => 'nullable|string|max:255',
            'recent_work_title' => 'nullable|string|max:255',
            'cinematography_subtitle' => 'nullable|string|max:255',
            'cinematography_title' => 'nullable|string|max:255',
            'ssl_status' => 'nullable|in:0,1',
            'ssl_sandbox' => 'nullable|in:0,1',
            'ssl_store_id' => 'nullable|string|max:255',
            'ssl_store_password' => 'nullable|string|max:255',
            'google_search_console_code' => 'nullable|string',
            'google_analytics_id' => 'nullable|string|max:255',
            'google_analytics_code' => 'nullable|string',
            'google_pixel_id' => 'nullable|string|max:255',
            'google_pixel_code' => 'nullable|string',
            'custom_head_code' => 'nullable|string',
            'custom_body_code' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'address' => 'nullable|string',
            'google_map' => 'nullable|string',
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
            'google_map' => $request->google_map,
            // 'messenger_username' => $request->messenger_username,
            'phone' => $request->phone,
            'since_year' => $request->since_year,
            'events_count' => $request->events_count,
            'photos_count' => $request->photos_count,
            'clients_count' => $request->clients_count,
            'service_subtitle' => $request->service_subtitle,
            'service_title' => $request->service_title,
            'recent_work_subtitle' => $request->recent_work_subtitle,
            'recent_work_title' => $request->recent_work_title,
            'cinematography_subtitle' => $request->cinematography_subtitle,
            'cinematography_title' => $request->cinematography_title,
            'ssl_status' => $request->has('ssl_status') ? (int)$request->ssl_status : 0,
            'ssl_sandbox' => $request->has('ssl_sandbox') ? (int)$request->ssl_sandbox : 0,
            'ssl_store_id' => $request->ssl_store_id,
            'ssl_store_password' => $request->ssl_store_password,
            'google_search_console_code' => $request->google_search_console_code,
            'google_analytics_id' => $request->google_analytics_id,
            'google_analytics_code' => $request->google_analytics_code,
            'google_pixel_id' => $request->google_pixel_id,
            'google_pixel_code' => $request->google_pixel_code,
            'custom_head_code' => $request->custom_head_code,
            'custom_body_code' => $request->custom_body_code,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            // 'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Content updated successfully.');
    }
}
