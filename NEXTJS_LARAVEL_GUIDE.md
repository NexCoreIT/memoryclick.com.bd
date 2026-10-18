# MemoryClick.com.bd: Complete Architecture & Developer Guide
### From Laravel Blade to Next.js and Finally to Modern Monolithic Laravel + Inertia.js + React

---

## 📖 Table of Contents
1. [Executive Summary: What Happened & Why](#1-executive-summary-what-happened--why)
2. [Non-Technical Guide (For Everyone & Day-to-Day Management)](#2-non-technical-guide-for-everyone--day-to-day-management)
   - [The Restaurant Analogy: Blade vs Next.js vs Inertia.js](#the-restaurant-analogy-blade-vs-nextjs-vs-inertiajs)
   - [Why cPanel Deployment with Next.js Was a Problem](#why-cpanel-deployment-with-nextjs-was-a-problem)
   - [Why Inertia.js is the Ultimate Solution](#why-inertiajs-is-the-ultimate-solution)
   - [How You Manage the Website Day-to-Day](#how-you-manage-the-website-day-to-day)
3. [Technical Deep-Dive (For Laravel Developers Learning React/Node)](#3-technical-deep-dive-for-laravel-developers-learning-reactnode)
   - [Core Concept: The Modern Monolith](#core-concept-the-modern-monolith)
   - [Laravel Blade vs. Inertia React: Side-by-Side Comparison](#laravel-blade-vs-inertia-react-side-by-side-comparison)
   - [How Data Flows: From MySQL to Browser Screen](#how-data-flows-from-mysql-to-browser-screen)
4. [Complete Project File & Directory Structure](#4-complete-project-file--directory-structure)
5. [Step-by-Step Breakdown: What Was Implemented](#5-step-by-step-breakdown-what-was-implemented)
   - [Step 1: Installing & Configuring Inertia in Laravel](#step-1-installing--configuring-inertia-in-laravel)
   - [Step 2: Root Blade Template (`app.blade.php`)](#step-2-root-blade-template-appbladephp)
   - [Step 3: Client Entrypoint & Dual-Payload Resolution (`app.jsx`)](#step-3-client-entrypoint--dual-payload-resolution-appjsx)
   - [Step 4: Converting Next.js Pages to Inertia Pages](#step-4-converting-nextjs-pages-to-inertia-pages)
   - [Step 5: Updating Laravel Controllers](#step-5-updating-laravel-controllers)
   - [Step 6: Vite Configuration & Build Pipeline](#step-6-vite-configuration--build-pipeline)
6. [Critical Bugs Diagnosed & Solved (Important Lessons)](#6-critical-bugs-diagnosed--solved-important-lessons)
   - [Bug 1: The Stale `public/hot` Dev Trap](#bug-1-the-stale-publichot-dev-trap)
   - [Bug 2: The Inertia v3 Blank White Screen (`reading 'component'`)](#bug-2-the-inertia-v3-blank-white-screen-reading-component)
   - [Bug 3: Swiper Slider SVG Overflow & Mobile Responsiveness](#bug-3-swiper-slider-svg-overflow--mobile-responsiveness)
   - [Bug 4: PowerShell Execution Policy on Windows](#bug-4-powershell-execution-policy-on-windows)
7. [Local Development Cheatsheet](#7-local-development-cheatsheet)
8. [cPanel Production Deployment Guide (Step-by-Step)](#8-cpanel-production-deployment-guide-step-by-step)

---

## 1. Executive Summary: What Happened & Why

Your project started as a traditional **Laravel + Blade + Bootstrap** web application. 

Later, a **Next.js (React + Node.js)** standalone frontend was created inside the `/frontend` folder. While Next.js gave blazing-fast single-page app (SPA) performance, it introduced a massive headache: **Deploying it on standard cPanel required two completely separate servers** (PHP for Laravel, and a constantly running Node.js server with PM2/Passenger for Next.js). On shared cPanel hosting, Node.js background services frequently crash, suffer from memory limits, require complex port proxying, and lead to CORS and SSL synchronization issues.

### The Solution:
You requested:
> *"Inertia.js দিয়ে ঠিক করে দাও যাতে লোডিং ০ থাকে এবং cPanel ডিপ্লয়ে কোনো সমস্যা না হয়।"*

We migrated the frontend into a unified **Laravel + Inertia.js + React** architecture.
- **In Development:** You have live hot-reloading using Vite.
- **In Production:** All React code is pre-compiled into standard static HTML/CSS/JS files inside `public/build/`.
- **On cPanel:** **Zero Node.js processes run on your server!** Your hosting only needs PHP and MySQL, exactly like a normal Laravel site, but your visitors experience an instantaneous, 0-refresh single-page app!

---

## 2. Non-Technical Guide (For Everyone & Day-to-Day Management)

### The Restaurant Analogy: Blade vs Next.js vs Inertia.js

```
Traditional Laravel Blade:
[ Customer ] <--- Full Paper Menu Reprinted Every Page Visit ---> [ Kitchen (PHP/MySQL) ]

Separate Next.js + Laravel:
[ Customer ] <--- Fancy Dining Room (Node.js) ---> Waiter (REST API) ---> [ Kitchen (PHP/MySQL) ]
(Needs TWO separate buildings to be rented and maintained!)

Inertia.js (Our Setup):
[ Customer ] <--- Dynamic Interactive Menu (React) ---> Kitchen Direct Order ---> [ Kitchen (PHP/MySQL) ]
(ONE building, one roof, instant service, zero extra rent!)
```

1. **Traditional Laravel Blade:**
   Every time a customer clicks a link ("Packages" or "About Us"), the browser throws away the current screen, downloads an entirely new HTML document from the server, and reloads from scratch.
2. **Standalone Next.js + Laravel API:**
   Requires two separate servers running 24/7. If the Node.js server runs out of RAM on cPanel, the entire frontend goes down while Laravel is still alive.
3. **Inertia.js:**
   Laravel remains the **single captain of the ship**. Laravel handles all routing, database queries, authentication, and payments. But instead of returning heavy HTML Blade templates, it sends lightweight data to React, which swaps the page content instantly without refreshing the browser.

---

### Why cPanel Deployment with Next.js Was a Problem

| Challenge | Standalone Next.js on cPanel | Inertia.js + Laravel on cPanel |
| :--- | :--- | :--- |
| **Server Requirements** | PHP 8.2 + MySQL + Node.js Daemon (PM2) | **PHP 8.2 + MySQL ONLY** |
| **Crash Risk** | High (Node process crashes when memory spikes) | **Zero (Standard PHP-FPM lifecycle)** |
| **Ports & Proxies** | Complex `.htaccess` reverse proxy from port 3000 to 80 | **Standard Apache/LiteSpeed web root** |
| **CORS & Cookies** | Required configuring Cross-Origin headers & CSRF cookies | **Native Laravel session & CSRF tokens** |
| **Deployment Effort** | 10+ steps (Setup Node app, npm install on cPanel, PM2 config) | **1 step: Upload files & run standard Laravel** |

---

### Why Inertia.js is the Ultimate Solution
- **Zero-Second Page Transitions:** When someone clicks from "Home" to "Packages", the header and footer stay mounted. Only the body content swaps instantly. No white flashing, no waiting.
- **100% Native Laravel Ecosystem:** You continue writing standard Laravel routes, controllers, middleware, and Eloquent queries.
- **No Node.js Daemon on Production:** Before uploading to cPanel, you run `npm run build` on your computer once. Vite bundles everything into static files. On cPanel, Apache/Nginx serves these static files directly at lightning speed.

---

### How You Manage the Website Day-to-Day

**You do NOT have to change how you manage your content!**
1. You still visit your admin panel: `http://memoryclick.com.bd/admin` (or `http://localhost:8000/admin` locally).
2. You log in with your existing admin credentials.
3. When you upload a new photo, add a package, or change website settings, Laravel saves it to MySQL.
4. When a visitor visits the homepage, Laravel pulls the new data from MySQL and feeds it to the React components. Everything updates automatically!

---

## 3. Technical Deep-Dive (For Laravel Developers Learning React/Node)

### Core Concept: The Modern Monolith

In traditional API-driven Single Page Applications (like Next.js + Laravel API), you have to:
1. Define a Laravel API route (`api.php`).
2. Write an API Controller returning JSON.
3. In Next.js, write an `axios.get('/api/packages')` call.
4. Manage loading spinners while waiting for the fetch to resolve.
5. Manage error states, JWT tokens, and CORS.

**With Inertia.js, all of that disappears:**
Inertia replaces the "View" layer of MVC. Instead of `return view('frontend.pages.home', $data)`, you write:
```php
return Inertia::render('Home', $data);
```
Laravel renders the page with the data already embedded. The browser loads the page with **zero network latency** and **zero loading spinners** on the initial visit!

---

### Laravel Blade vs. Inertia React: Side-by-Side Comparison

As a Laravel developer with 3 years of Blade experience, here is your mental translation map:

| Concept | Traditional Laravel Blade | Modern Inertia React |
| :--- | :--- | :--- |
| **Layout Wrapper** | `@extends('frontend.layout.master')` | `<AppLayout title="...">...</AppLayout>` |
| **Yielding Content** | `@yield('content')` | `{children}` in `AppLayout.jsx` |
| **Printing Variables** | `{{ $service->title }}` | `{service.title}` |
| **Conditionals** | `@if($package->price) ... @endif` | `{package.price && <div>...</div>}` |
| **Loops** | `@foreach($sliders as $slider) ... @endforeach` | `{sliders.map(slider => <div key={slider.id}>...</div>)}` |
| **Links / Navigation**| `<a href="{{ route('about') }}">About</a>` | `<Link href="/about">About</Link>` *(client-side routing)* |
| **Page Title & SEO** | `@section('title', 'About Us')` | `<Head><title>About Us</title></Head>` |
| **Forms & Submissions** | `<form action="/contact" method="POST">` | `const { data, setData, post } = useForm({...})` |
| **Flash Messages** | `session('success')` | `usePage().props.flash.success` |
| **Global Settings** | View Composers / Global Helpers | `HandleInertiaRequests::share()` |

---

### How Data Flows: From MySQL to Browser Screen

```
1. Visitor requests URL: http://memoryclick.com.bd/
                     │
                     ▼
2. Laravel Route: routes/web.php
   Route::get('/', [HomeController::class, 'index'])
                     │
                     ▼
3. Controller: app/Http/Controllers/frontend/HomeController.php
   - Fetches Sliders, Services, Packages, Reviews from MySQL
   - Calls: return Inertia::render('Home', [...data...]);
                     │
                     ▼
4. Middleware: app/Http/Middleware/HandleInertiaRequests.php
   - Automatically injects global settings (Logo, Phone, Social Links, Flash messages)
                     │
                     ▼
5. Root Blade: resources/views/app.blade.php
   - Injects compiled CSS/JS from public/build/
   - Renders: <script data-page="app" type="application/json">{...data...}</script>
              <div id="app"></div>
                     │
                     ▼
6. Browser executes: resources/js/app.jsx
   - Reads data payload from the DOM
   - Resolves resources/js/Pages/Home.jsx
   - Mounts React into <div id="app"></div>
   - Displays fully rendered, interactive page in 0 milliseconds!
```

---

## 4. Complete Project File & Directory Structure

Here is the exact map of the key files governing this application:

```
memoryclick.com.bd/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── frontend/
│   │   │   │   ├── HomeController.php        <-- Returns Inertia::render for Home, About, Packages, Portfolio
│   │   │   │   └── BlogController.php        <-- Returns Inertia::render for Blog Index & Details
│   │   │   └── SslCommerzPaymentController.php <-- Inertia::render for Payment Success/Fail/Cancel
│   │   ├── Middleware/
│   │   │   └── HandleInertiaRequests.php     <-- Global shared data (Logo, Contact, Socials, Flash)
│   │   └── Kernel.php                        <-- Registers HandleInertiaRequests in 'web' middleware group
├── config/
│   └── inertia.php                           <-- Inertia configuration (use_script_element_for_initial_page = true)
├── resources/
│   ├── views/
│   │   ├── app.blade.php                     <-- Single root template for all customer frontend pages
│   │   └── backend/                          <-- UNTOUCHED: Original Blade views for admin panel
│   ├── css/
│   │   ├── app.css                           <-- Master CSS (Bootstrap, Swiper styles, custom colors)
│   │   └── styles/                           <-- Original vendor CSS (style.css, bootstrap.min.css)
│   └── js/
│       ├── app.jsx                           <-- Inertia client entrypoint (creates root, resolves pages)
│       ├── bootstrap.js                      <-- Axios client setup
│       ├── Components/                       <-- Reusable UI blocks
│       │   ├── Layout/
│       │   │   ├── AppLayout.jsx             <-- Master layout with SEO <Head>, Header, Footer, WhatsApp
│       │   │   ├── Header.jsx                <-- Desktop & mobile drawer navbar with active route pills
│       │   │   ├── Footer.jsx                <-- Footer with dynamic settings & developer credits
│       │   │   └── WhatsAppButton.jsx        <-- Floating animated WhatsApp CTA
│       │   └── Home/
│       │       ├── HeroSlider.jsx            <-- Swiper hero banner with autoplay
│       │       ├── StatsSection.jsx          <-- Experience counters & about teaser
│       │       ├── ServicesCarousel.jsx      <-- Top services carousel with brand buttons
│       │       ├── LatestPackagesSection.jsx <-- Latest packages grid with modal trigger
│       │       ├── PackageDetailsModal.jsx   <-- Interactive popup with SSLCommerz checkout button
│       │       ├── TestimonialsCarousel.jsx  <-- Client reviews carousel with expandable text
│       │       ├── RecentWorkSection.jsx     <-- Recent photography grid
│       │       ├── CinematographyCarousel.jsx<-- Responsive embedded YouTube video carousel
│       │       ├── HomeBlogSection.jsx       <-- Latest news & insights cards
│       │       └── HomeContactSection.jsx    <-- Contact info & interactive contact message form
│       ├── Pages/                            <-- Full page components mapped to controllers
│       │   ├── Home.jsx                      <-- Inertia::render('Home')
│       │   ├── About.jsx                     <-- Inertia::render('About')
│       │   ├── Photography/
│       │   │   ├── Index.jsx                 <-- Category filtered photography gallery
│       │   │   └── Details.jsx               <-- Photo album with lightbox preview
│       │   ├── Cinematography.jsx            <-- Video collection grid
│       │   ├── Package/
│       │   │   ├── Index.jsx                 <-- All packages with category filtering
│       │   │   └── Division.jsx              <-- Division/branch specific packages
│       │   ├── Services/
│       │   │   ├── Index.jsx                 <-- All services list
│       │   │   └── Details.jsx               <-- Individual service detail page
│       │   ├── Blog/
│       │   │   ├── Index.jsx                 <-- Blog list with categories & pagination
│       │   │   └── Details.jsx               <-- Full blog article reader
│       │   ├── Contact.jsx                   <-- Dedicated contact page with map & form
│       │   ├── TermAndConditions.jsx         <-- Terms & conditions policy page
│       │   ├── Checkout.jsx                  <-- Order checkout form before payment gateway
│       │   └── Payment/
│       │       ├── Success.jsx               <-- Payment approved confirmation page
│       │       ├── Fail.jsx                  <-- Payment failed retry page
│       │       └── Cancel.jsx                <-- Payment cancelled page
│       └── Utils/
│           └── image.js                      <-- Helper to safely resolve absolute image URLs
├── public/
│   ├── build/                                <-- Compiled production assets (generated by Vite)
│   │   ├── manifest.json                     <-- Asset hash dictionary
│   │   └── assets/                           <-- app-xxxx.js and app-xxxx.css
│   └── frontend/                             <-- Static images, icons, favicons
├── routes/
│   └── web.php                               <-- Laravel web routes returning Inertia pages
├── vite.config.js                            <-- Vite configuration with Laravel & React plugins
└── package.json                              <-- Frontend dependencies & build scripts
```

---

## 5. Step-by-Step Breakdown: What Was Implemented

### Step 1: Installing & Configuring Inertia in Laravel
We installed the official server adapter:
```bash
composer require inertiajs/inertia-laravel
```
Then generated and configured the middleware:
```bash
php artisan inertia:middleware
```
Inside [app/Http/Middleware/HandleInertiaRequests.php](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/app/Http/Middleware/HandleInertiaRequests.php), we defined globally available shared props so that the Header, Footer, and SEO tags receive website settings, contact info, and session flash messages on every single page automatically without having to pass them manually in every controller method.

---

### Step 2: Root Blade Template (`app.blade.php`)
We created [resources/views/app.blade.php](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/resources/views/app.blade.php):
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/favicon.ico') }}">

    <!-- Google Web Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @inertiaHead
</head>
<body class="antialiased">
    @inertia
</body>
</html>
```

---

### Step 3: Client Entrypoint & Dual-Payload Resolution (`app.jsx`)
In [resources/js/app.jsx](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/resources/js/app.jsx), we configured the Inertia client. We engineered a dual-fallback payload reader (`getPagePayload`) to guarantee that whether the HTML contains a `<script data-page="app">` tag or `<div id="app" data-page="...">`, the app mounts cleanly without throwing null pointer exceptions:

```javascript
import './bootstrap';
import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';

const appName = 'Memory Click';

function getPagePayload() {
    if (typeof window === 'undefined') return undefined;

    // 1. Modern Inertia JSON script element
    const scriptEl = document.querySelector('script[data-page="app"][type="application/json"]');
    if (scriptEl && scriptEl.textContent) {
        try { return JSON.parse(scriptEl.textContent); } catch (e) {}
    }

    // 2. Classic Inertia div[data-page] element
    const appEl = document.getElementById('app');
    if (appEl && appEl.dataset && appEl.dataset.page) {
        try { return JSON.parse(appEl.dataset.page); } catch (e) {}
    }

    return undefined;
}

createInertiaApp({
    id: 'app',
    page: getPagePayload(),
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true });
        const page = pages[`./Pages/${name}.jsx`];
        if (!page) {
            throw new Error(`Page "./Pages/${name}.jsx" not found.`);
        }
        return page.default || page;
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#EAA636',
        showSpinner: true,
    },
});
```

---

### Step 4: Converting Next.js Pages to Inertia Pages
Every component previously written in TypeScript/Next.js (`frontend/src/...`) was adapted to idiomatic Inertia.js React (`resources/js/...`):
- Replaced `next/link` with `@inertiajs/react`'s `<Link href="...">`.
- Replaced `next/navigation` (`useRouter`, `useSearchParams`) with Inertia's native `router.get(...)` and `usePage().url`.
- Replaced manual `fetch('/api/...')` with Inertia's `useForm` for instant, CSRF-protected form submissions (`post('/contact-store')`).
- Replaced Next.js `<Image>` with high-performance responsive `<img>` tags powered by `resolveImageUrl()` to support both local Laragon URLs and live production media.

---

### Step 5: Updating Laravel Controllers
In [app/Http/Controllers/frontend/HomeController.php](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/app/Http/Controllers/frontend/HomeController.php) and [BlogController.php](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/app/Http/Controllers/frontend/BlogController.php):
- Replaced `return view('frontend.pages.home', ...)` with `return Inertia::render('Home', [...])`.
- Replaced `return view('frontend.about.index', ...)` with `return Inertia::render('About', [...])`.
- Replaced `return view('frontend.package.index', ...)` with `return Inertia::render('Package/Index', [...])`.
- Maintained all existing Eloquent relationships, sorting, and image formatters so that no database query had to be rewritten.

---

### Step 6: Vite Configuration & Build Pipeline
In [vite.config.js](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/vite.config.js):
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
```

---

## 6. Critical Bugs Diagnosed & Solved (Important Lessons)

During our pair-programming session, we encountered and solved four subtle, real-world bugs. Documenting them here will save you hours in the future:

### Bug 1: The Stale `public/hot` Dev Trap
- **The Symptom:** When visiting `http://127.0.0.1:8000`, the browser displayed a blank white screen with `net::ERR_CONNECTION_REFUSED` on port 5173.
- **The Root Cause:** When you run `npm run dev`, Vite creates a temporary file named [public/hot](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/public/hot) containing `http://[::1]:5173`. If you stop the Vite terminal uncleanly, this file stays behind. Laravel sees `public/hot` and instructs the browser to download scripts from port 5173 instead of serving pre-compiled files from `public/build/`.
- **The Fix:** Deleted `public/hot`. Always remember: **If you are NOT running `npm run dev`, make sure `public/hot` does not exist on disk!**

---

### Bug 2: The Inertia v3 Blank White Screen (`reading 'component'`)
- **The Symptom:** Chrome console showed:
  `Uncaught (in promise) TypeError: Cannot read properties of null (reading 'component')`.
- **The Root Cause:** We installed modern `@inertiajs/react` (v3). Under Inertia v3, the client DOM parser strictly searches for `<script data-page="app" type="application/json">`. However, Laravel's `inertia-laravel` package defaults `use_script_element_for_initial_page` to `false`, rendering `<div id="app" data-page="...">`. Because the script tag wasn't found, Inertia returned `initialPage = null` and crashed before mounting.
- **The Fix:**
  1. Published [config/inertia.php](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/config/inertia.php) and set:
     ```php
     'use_script_element_for_initial_page' => (bool) env('INERTIA_USE_SCRIPT_ELEMENT_FOR_INITIAL_PAGE', true),
     ```
  2. Added `INERTIA_USE_SCRIPT_ELEMENT_FOR_INITIAL_PAGE=true` to `.env`.
  3. Added the `getPagePayload()` dual-fallback helper in `resources/js/app.jsx` to make it bulletproof.

---

### Bug 3: Swiper Slider SVG Overflow & Mobile Responsiveness
- **The Symptom:** In the "Our Top Services" carousel, the navigation arrows were oversized chevrons sticking out of the circular button, washed out in color, and overlapping cards on mobile devices.
- **The Root Cause:** Modern Swiper renders inline `<svg class="swiper-navigation-icon">` tags with default CSS `width: 100%; height: 100%`. In a 44px button, the SVG stretched to the full 44px border.
- **The Fix:**
  In [resources/css/app.css](file:///d:/laragon/www/MyProjects/memoryclick.com.bd/resources/css/app.css):
  - Strictly constrained the SVG: `width: 14px !important; height: 14px !important;`.
  - Applied the signature brand styling: Solid `#EAA636` gold background with crisp white `#FFFFFF` icon and subtle glow shadow.
  - Hover state transitions to luxury dark `#1E1916` with golden arrow and `scale(1.08)`.
  - Added media query for mobile (`< 768px`): Buttons scale down to `36px × 36px` with `12px` icon and safe margin so they never block cards.

---

### Bug 4: PowerShell Execution Policy on Windows
- **The Symptom:** Running `npm run build` in Windows PowerShell failed with:
  `File npm.ps1 cannot be loaded because running scripts is disabled on this system.`
- **The Fix:** On Windows, execute via **`npm.cmd run build`** or **`npm.cmd run dev`**. This bypasses PowerShell script execution policy restrictions completely.

---

## 7. Local Development Cheatsheet

### Mode 1: Production Simulation (Just like cPanel)
Use this mode when testing how the website performs as a static bundle without any Node daemon:
1. Open one terminal in the project root:
   ```powershell
   npm.cmd run build
   php artisan serve
   ```
2. Visit `http://127.0.0.1:8000` in your browser.
3. No Node process is needed! Everything runs directly from `public/build/`.

### Mode 2: Live Hot-Reloading (When editing React code)
Use this mode when actively styling or editing JSX components:
1. **Terminal 1 (Laravel Server):**
   ```powershell
   php artisan serve
   ```
2. **Terminal 2 (Vite Hot Reload):**
   ```powershell
   npm.cmd run dev
   ```
3. Visit `http://127.0.0.1:8000`. Any change you make to JSX or CSS will instantly reflect in your browser without needing to refresh!
4. **When you are done:** Stop Terminal 2 (`Ctrl + C`) and run `npm.cmd run build` once to generate updated production files.

---

## 8. cPanel Production Deployment Guide (Step-by-Step)

Because this is a standard Laravel monolith with pre-compiled assets, deploying to cPanel is 100% standard and requires **NO Node.js setup in cPanel**.

### Step 1: Compile Assets Locally
On your computer, open your project terminal and run:
```powershell
npm.cmd run build
```
Verify that `public/build/` contains `manifest.json` and the `assets/` folder.
Verify that `public/hot` **does not exist** (delete it if it is there).

### Step 2: Upload Files to cPanel
Compress and upload your project files to your cPanel directory (e.g. `public_html` or a subfolder).
*Make sure you upload the `public/build/` directory!*
*(Do NOT upload `node_modules` — it is not needed on the server).*

### Step 3: Configure `.env` on cPanel
Ensure your cPanel `.env` has:
```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://memoryclick.com.bd

INERTIA_USE_SCRIPT_ELEMENT_FOR_INITIAL_PAGE=true
```

### Step 4: Run Laravel Optimizations
In your cPanel Terminal (or via SSH / Cron job):
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### Done! 🎉
Your website is live at `https://memoryclick.com.bd`. It will load instantaneously as a full Single Page Application, while running completely on shared PHP hosting without any Node.js background daemons!
