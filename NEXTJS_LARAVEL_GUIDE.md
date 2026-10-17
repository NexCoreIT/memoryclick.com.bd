# Complete Guide: Laravel Backend + Next.js Frontend
## Memory Click (memoryclick.com.bd)

Welcome! This guide was specially written for you. If you are comfortable with **PHP Laravel, Blade templates, Bootstrap, Tailwind, and MySQL**, but this is your **very first time working with Node.js and Next.js**, this document will give you 100% clarity.

---

# Table of Contents
1. [PART 1: The Non-Technical Guide (Easy to Understand)](#part-1-the-non-technical-guide)
   - [The Restaurant Analogy](#the-restaurant-analogy)
   - [What Changed vs. What Stayed the Same](#what-changed-vs-what-stayed-the-same)
   - [How You Manage the Website Day-to-Day](#how-you-manage-the-website-day-to-day)
2. [PART 2: The Technical Guide (For Laravel Developers)](#part-2-the-technical-guide)
   - [Translating Blade Concepts into Next.js & React](#translating-blade-concepts-into-nextjs--react)
   - [How Next.js Communicates with Laravel (REST API & CORS)](#how-nextjs-communicates-with-laravel)
   - [Folder Structure Overview](#folder-structure-overview)
   - [How the Admin Panel Works (/admin)](#how-the-admin-panel-works)
3. [PART 3: Day-to-Day Local Development Workflow](#part-3-day-to-day-local-development-workflow)
   - [Starting the Laravel Backend (php artisan serve or Laragon)](#starting-the-laravel-backend)
   - [Starting the Next.js Frontend (npm run dev)](#starting-the-nextjs-frontend)
   - [Switching Backend URLs in .env.local](#switching-backend-urls-in-envlocal)
4. [PART 4: Step-by-Step Local Installation (New Machine Setup)](#part-4-step-by-step-local-installation)
5. [PART 5: Step-by-Step Server & Production Deployment](#part-5-step-by-step-server--production-deployment)
   - [Production Architecture](#production-architecture)
   - [Deploying on a VPS (Ubuntu + Nginx + PM2)](#deploying-on-a-vps)
   - [Deploying on cPanel](#deploying-on-cpanel)
6. [PART 6: Troubleshooting & Common FAQs](#part-6-troubleshooting--common-faqs)

---

# PART 1: The Non-Technical Guide

### The Restaurant Analogy

Think of your website like a modern restaurant:

```
+--------------------------------------------------------------+
|                        THE RESTAURANT                        |
+--------------------------------------------------------------+
|                                                              |
|   [ CUSTOMER / BROWSER ]                                     |
|             |                                                |
|             v                                                |
|   [ FRONT OF HOUSE / DINING ROOM ]  <-- Next.js (Node.js)    |
|   Beautiful tables, lighting, menus, smooth experience.      |
|             |                                                |
|             | (Waiter delivers orders & brings food via API) |
|             v                                                |
|   [ THE KITCHEN & PANTRY ]          <-- Laravel & MySQL      |
|   Where the recipes are stored, food is cooked, and bills    |
|   are safely processed. Admin sits in the kitchen office.    |
|                                                              |
+--------------------------------------------------------------+
```

1. **Before this conversion:**
   Laravel did *both* jobs. It cooked the food in the kitchen (database queries, calculations) and also hand-crafted every HTML page on the fly and sent it to the browser.
2. **After this conversion:**
   - **Laravel** remains the chef and brain in the kitchen. It guards the database, checks passwords, processes SSLCommerz payments, and manages admin operations.
   - **Next.js (Node.js)** is the modern dining room. It delivers instantaneous page transitions, animations, interactive modals, and blazing speed without reloading the entire page.
   - **The Waiter (REST API):** Whenever Next.js needs information (like "give me the wedding packages" or "submit this contact form"), it asks Laravel via a secure JSON message. Laravel answers, and Next.js instantly displays it.

### What Changed vs. What Stayed the Same

| Feature | Did It Change? | Explanation |
| :--- | :---: | :--- |
| **MySQL Database** | **NO (100% Intact)** | All your tables, rows, images, orders, packages, and users are completely untouched. |
| **Admin Dashboard (`/admin`)** | **NO (100% Intact)** | You still log into your exact same Laravel Admin panel to add packages, upload photos, edit sliders, and view orders. |
| **Business Logic** | **NO (100% Intact)** | Pricing, payment calculations, email notifications, and database relationships remain in Laravel. |
| **Public Customer Frontend** | **YES (Upgraded)** | Replaced Laravel Blade files with Next.js (React) for ultra-fast performance, modern animations, and smooth mobile experience. |

### How You Manage the Website Day-to-Day

**You do NOT have to change how you manage your content!**
1. You still go to your admin URL: **`http://localhost:8000/admin`** (or `http://localhost:3000/admin` which automatically forwards you).
2. You log in with your normal admin email and password.
3. You create a new Package, upload a new Photography shoot, or change contact numbers just like before.
4. Because the Next.js frontend fetches fresh data from Laravel's REST API, **your changes appear on the Next.js frontend immediately!**

---

# PART 2: The Technical Guide (For Laravel Developers)

As a Laravel developer, you already know PHP, Blade, routing, and controllers. Here is how every Laravel concept directly maps to Next.js:

### Translating Blade Concepts into Next.js & React

#### 1. Layouts: `@extends('layout')` vs `layout.tsx`
- **In Blade:** You made a `layouts/app.blade.php` and used `@yield('content')`.
- **In Next.js:** You have `frontend/src/app/layout.tsx`. The `{children}` prop is where the page content automatically renders:
  ```tsx
  export default function RootLayout({ children }: { children: React.ReactNode }) {
    return (
      <html lang="en">
        <body>
          <Header />
          <main>{children}</main>  {/* Equivalent to @yield('content') */}
          <Footer />
        </body>
      </html>
    );
  }
  ```

#### 2. Partials: `@include('partials.header')` vs Components `<Header />`
- **In Blade:** `@include('frontend.partials.header')`
- **In Next.js:** You import the component at the top of the file:
  ```tsx
  import Header from "@/components/layout/Header";
  // Then in your JSX:
  <Header />
  ```

#### 3. Printing Variables: `{{ $package->name }}` vs `{package.name}`
- **In Blade:** `<h3>{{ $package->name }}</h3>`
- **In Next.js:** `<h3>{package.name}</h3>`

#### 4. Loops: `@foreach($packages as $pkg)` vs `.map()`
- **In Blade:**
  ```blade
  @foreach($packages as $pkg)
      <div class="card">{{ $pkg->name }}</div>
  @endforeach
  ```
- **In Next.js:**
  ```tsx
  {packages.map((pkg) => (
    <div key={pkg.id} className="card">
      {pkg.name}
    </div>
  ))}
  ```
  *(Notice: In React, HTML attribute `class` is written as `className` because `class` is a reserved JavaScript keyword).*

#### 5. Conditions: `@if($is_featured)` vs `{is_featured && ...}`
- **In Blade:**
  ```blade
  @if($package->is_featured)
      <span class="badge">Featured</span>
  @endif
  ```
- **In Next.js:**
  ```tsx
  {package.is_featured && <span className="badge">Featured</span>}
  ```

#### 6. Routing: `routes/web.php` vs File-System Routing
In Next.js App Router, folder names are URLs automatically:

| URL | Laravel Route (`web.php`) | Next.js File Path |
| :--- | :--- | :--- |
| `/` | `Route::get('/', ...)` | `frontend/src/app/page.tsx` |
| `/about` | `Route::get('/about', ...)` | `frontend/src/app/about/page.tsx` |
| `/photography` | `Route::get('/photography', ...)` | `frontend/src/app/photography/page.tsx` |
| `/photography/{slug}` | `Route::get('/photography/{slug}', ...)` | `frontend/src/app/photography/[slug]/page.tsx` |
| `/package` | `Route::get('/package', ...)` | `frontend/src/app/package/page.tsx` |
| `/contact-us` | `Route::get('/contact-us', ...)` | `frontend/src/app/contact-us/page.tsx` |
| `/checkout` | `Route::get('/checkout', ...)` | `frontend/src/app/checkout/page.tsx` |

---

### How Next.js Communicates with Laravel

Next.js asks Laravel for information using standard HTTP `fetch()` calls.

```
[ Next.js Page ] ---(GET /api/home)---> [ Laravel Api Controller ] ---> [ MySQL DB ]
                 <---(JSON data)------- [ Returns JsonResponse ]  <---
```

1. **Where the API controllers live:**
   Check the folder: `app/Http/Controllers/Api/` in your Laravel project:
   - `SettingsApiController.php`
   - `HomeApiController.php`
   - `PackageApiController.php`
   - `ServiceApiController.php`
   - `PhotographyApiController.php`
   - `CinematographyApiController.php`
   - `BlogApiController.php`
   - `ContactApiController.php`
   - `PaymentApiController.php`
2. **Where the API routes are registered:**
   In your existing `routes/api.php` file.
3. **CORS (Cross-Origin Resource Sharing):**
   Because Next.js runs on port `3000` and Laravel runs on port `8000` (or Apache), the browser needs permission to talk between them. We configured this in `config/cors.php`:
   ```php
   'allowed_origins' => [
       'http://localhost:3000',
       'http://127.0.0.1:3000',
       env('FRONTEND_URL', 'http://localhost:3000'),
   ],
   ```

---

### Folder Structure Overview

```
memoryclick.com.bd/                     <-- ROOT LARAVEL PROJECT
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/                        <-- 12 NEW REST API CONTROLLERS
│   │   │   ├── HomeApiController.php
│   │   │   ├── PackageApiController.php
│   │   │   └── ...
│   │   └── ... (All existing controllers preserved)
│   └── Models/                         <-- ALL ELOQUENT MODELS PRESERVED
├── config/
│   └── cors.php                        <-- CONFIGURED FOR PORT 3000
├── routes/
│   ├── api.php                         <-- REST API ROUTES
│   └── web.php                         <-- ADMIN ROUTES & REDIRECTS
├── resources/views/                    <-- EXISTING ADMIN BLADE VIEWS
│   └── backend/admin/                  <-- 100% UNTOUCHED
├── .env                                <-- LARAVEL CONFIG (DB, APP_KEY)
│
└── frontend/                           <-- NEW NEXT.JS FRONTEND APPLICATION
    ├── public/                         <-- Images, logos, favicons, static files
    ├── src/
    │   ├── app/                        <-- All website pages (App Router)
    │   │   ├── layout.tsx              <-- Global Layout (Header, Footer, Meta)
    │   │   ├── page.tsx                <-- Homepage
    │   │   ├── about/page.tsx
    │   │   ├── photography/page.tsx
    │   │   ├── photography/[slug]/
    │   │   ├── cinematography/page.tsx
    │   │   ├── package/page.tsx
    │   │   ├── division/[slug]/package/
    │   │   ├── blog/page.tsx
    │   │   ├── contact-us/page.tsx
    │   │   ├── checkout/page.tsx
    │   │   └── ...
    │   ├── components/                 <-- Reusable UI components
    │   │   ├── home/                   <-- HeroSlider, Packages, Services, Reviews
    │   │   ├── layout/                 <-- Header, Footer, WhatsAppButton
    │   │   └── ui/                     <-- Breadcrumb, Modals, Lightbox
    │   ├── lib/
    │   │   └── api.ts                  <-- Central API client functions
    │   └── styles/                     <-- Custom CSS & Bootstrap styles
    ├── .env.local                      <-- Frontend environment variables
    ├── package.json                    <-- Node.js dependencies
    └── next.config.ts                  <-- Next.js build & redirect rules
```

---

### How the Admin Panel Works

Your admin panel remains **pure Laravel Blade**. You don't have to rewrite or change a single admin view!

- If you run Laravel with `php artisan serve`, your admin is at:
  **`http://127.0.0.1:8000/admin`** (or `http://127.0.0.1:8000/auth/login`)
- If someone visits **`http://localhost:3000/admin`** on the Next.js port, Next.js automatically detects it and **redirects directly to the Laravel admin dashboard**!

---

# PART 3: Day-to-Day Local Development Workflow

When you develop on your computer, you run **two terminal windows**:

```
TERMINAL 1 (Laravel Backend)           TERMINAL 2 (Next.js Frontend)
$ php artisan serve                    $ cd frontend
Listening on http://127.0.0.1:8000     $ npm run dev
                                       Ready on http://localhost:3000
```

### Starting the Laravel Backend

Open your first terminal in the project root:
```bash
# Navigate to the root folder
cd d:\laragon\www\MyProjects\memoryclick.com.bd

# Run Laravel
php artisan serve
```
Your backend will start at: `http://127.0.0.1:8000`

### Starting the Next.js Frontend

Open a **second terminal**:
```bash
# Enter the frontend folder
cd d:\laragon\www\MyProjects\memoryclick.com.bd\frontend

# Start Next.js dev server
npm run dev
```
Your frontend will start at: **`http://localhost:3000`**

Open `http://localhost:3000` in Google Chrome or your favorite browser!

---

### Switching Backend URLs in `.env.local`

In `frontend/.env.local`, you can easily toggle between **Laragon Apache** and **`php artisan serve`** by uncommenting the one you are using:

```bash
# -------------------------------------------------------------
# If you run "php artisan serve" (Port 8000) -> USE THIS:
# -------------------------------------------------------------
NEXT_PUBLIC_API_URL=http://127.0.0.1:8000/api
NEXT_PUBLIC_BACKEND_URL=http://127.0.0.1:8000

# -------------------------------------------------------------
# If you run Laragon Apache -> USE THIS:
# -------------------------------------------------------------
# NEXT_PUBLIC_API_URL=http://localhost/MyProjects/memoryclick.com.bd/public/api
# NEXT_PUBLIC_BACKEND_URL=http://localhost/MyProjects/memoryclick.com.bd/public

# Next.js Frontend URL
NEXT_PUBLIC_SITE_URL=http://localhost:3000
```
> [!TIP]
> After modifying `frontend/.env.local`, restart your Next.js terminal (`Ctrl + C`, then `npm run dev`) so it loads the new environment variables.

---

# PART 4: Step-by-Step Local Installation

If you move this project to a new computer or another team member clones it:

### Step 1: Install Required Software
1. **PHP >= 8.2** & **Composer** (Already installed with Laragon).
2. **Node.js (LTS version)**: Download and install from [https://nodejs.org](https://nodejs.org) (v20 or v22 recommended).
3. **MySQL Server** (Already running via Laragon).

### Step 2: Set Up Laravel Backend
```bash
cd memoryclick.com.bd

# Install PHP packages
composer install

# Copy .env if not present
cp .env.example .env

# Generate app key
php artisan key:generate

# Run database migrations
php artisan migrate

# Start Laravel
php artisan serve
```

### Step 3: Set Up Next.js Frontend
```bash
# Go into the frontend folder
cd frontend

# Install Node.js packages (this creates node_modules)
npm install

# Ensure .env.local exists (it contains the backend URLs)
# If missing, copy from .env.example:
cp .env.example .env.local

# Start Next.js development server
npm run dev
```
Visit `http://localhost:3000`. That's it!

---

# PART 5: Step-by-Step Server & Production Deployment

When deploying to production, the recommended architecture is:

- **Frontend Domain:** `https://memoryclick.com.bd` (Points to Next.js on port 3000)
- **Backend Domain/Subdomain:** `https://api.memoryclick.com.bd` (Points to Laravel `public/` directory)

---

### Deploying on a VPS (Ubuntu / Debian + Nginx + PM2)

#### Step 1: Install Node.js and PM2 on the Server
```bash
# Install Node.js 20 LTS
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install PM2 (Process Manager to keep Next.js running forever)
sudo npm install -g pm2
```

#### Step 2: Deploy & Configure the Laravel Backend
1. Clone your project to `/var/www/memoryclick.com.bd`:
   ```bash
   cd /var/www/memoryclick.com.bd
   composer install --no-dev --optimize-autoloader
   ```
2. Update `/var/www/memoryclick.com.bd/.env`:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://api.memoryclick.com.bd
   FRONTEND_URL=https://memoryclick.com.bd

   DB_DATABASE=your_production_db
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```
3. Cache Laravel routes and configuration:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Set folder permissions:
   ```bash
   sudo chown -R www-data:www-data storage bootstrap/cache
   sudo chmod -R 775 storage bootstrap/cache
   ```

#### Step 3: Build & Start the Next.js Frontend with PM2
1. Go into the `frontend` directory:
   ```bash
   cd /var/www/memoryclick.com.bd/frontend
   ```
2. Create or edit `.env.local` for production:
   ```env
   NEXT_PUBLIC_API_URL=https://api.memoryclick.com.bd/api
   NEXT_PUBLIC_BACKEND_URL=https://api.memoryclick.com.bd
   NEXT_PUBLIC_SITE_URL=https://memoryclick.com.bd
   ```
3. Install dependencies and build the production bundle:
   ```bash
   npm install
   npm run build
   ```
4. Launch with PM2 so it automatically restarts on server reboots:
   ```bash
   pm2 start npm --name "memoryclick-frontend" -- start
   pm2 save
   pm2 startup
   ```

#### Step 4: Configure Nginx (Reverse Proxy)

Create an Nginx configuration file: `/etc/nginx/sites-available/memoryclick.conf`:

```nginx
# -------------------------------------------------------------
# 1. FRONTEND: Next.js (https://memoryclick.com.bd)
# -------------------------------------------------------------
server {
    server_name memoryclick.com.bd www.memoryclick.com.bd;

    location / {
        proxy_pass http://127.0.0.1:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}

# -------------------------------------------------------------
# 2. BACKEND & ADMIN: Laravel (https://api.memoryclick.com.bd)
# -------------------------------------------------------------
server {
    server_name api.memoryclick.com.bd;
    root /var/www/memoryclick.com.bd/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable the site and obtain free SSL certificates:
```bash
sudo ln -s /etc/nginx/sites-available/memoryclick.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Install SSL with Certbot
sudo certbot --nginx -d memoryclick.com.bd -d www.memoryclick.com.bd -d api.memoryclick.com.bd
```

---

### Deploying on cPanel

If your hosting is a standard cPanel account:
1. **Backend (Laravel):**
   - Upload the Laravel project files.
   - Point your main domain or subdomain (e.g., `api.memoryclick.com.bd`) document root to the `public/` directory.
   - Set up your MySQL database in cPanel MySQL Database Wizard.
2. **Frontend (Next.js):**
   - In cPanel, click **"Setup Node.js App"** (CloudLinux / Passenger).
   - Select Node.js version 20 or higher.
   - Set **Application root** to `frontend`.
   - Set **Application startup file** to `node_modules/next/dist/bin/next` or create a simple `server.js`.
   - Add environment variables (`NEXT_PUBLIC_API_URL`, etc.) in the cPanel Node.js interface.
   - Click **Run NPM Install**, then click **Run JS script** -> `build`.
   - Start the application.

---

# PART 6: Troubleshooting & Common FAQs

### Q1: Why aren't images loading on the frontend?
**Reason:** Next.js needs to know the full URL where images are hosted.
- Check `frontend/.env.local`.
- Make sure `NEXT_PUBLIC_BACKEND_URL` points to your running Laravel backend (e.g., `http://127.0.0.1:8000`).
- If you use `php artisan serve`, images will be served from `http://127.0.0.1:8000/uploads/...`.

### Q2: What if I see a "CORS" error in the browser console?
**Reason:** The backend is rejecting requests from a domain it doesn't recognize.
- Open `config/cors.php` in Laravel.
- Ensure your frontend URL (e.g., `http://localhost:3000` or `https://memoryclick.com.bd`) is listed in `'allowed_origins'`.
- Run `php artisan config:clear`.

### Q3: How do I edit text or layout on a page?
- Homepage elements: Look inside `frontend/src/components/home/`. For example, `HeroSlider.tsx`, `LatestPackagesSection.tsx`, `ServicesCarousel.tsx`.
- Header & Navigation: Edit `frontend/src/components/layout/Header.tsx`.
- Footer: Edit `frontend/src/components/layout/Footer.tsx`.
- Colors & Styling: Edit `frontend/src/app/globals.css`.

### Q4: Can I still edit my Blade views?
- For the **Admin Panel** (`resources/views/backend/admin/*`): **YES**, absolutely! Everything in the admin uses Blade exactly as before.
- For the **Public Website**: Next.js is now serving the public site. To change public pages, edit the files in `frontend/src/app/`.

### Q5: How do SSLCommerz payments work now?
1. The user clicks "Book Now" or chooses a package on Next.js.
2. The user fills in their name, phone, and event date on `/checkout`.
3. The Next.js frontend calls `/api/checkout/pay` on Laravel.
4. Laravel initializes the payment with SSLCommerz and returns the SSLCommerz gateway payment URL.
5. The user is redirected to SSLCommerz to complete the payment via bKash, Nagad, or Card.
6. Upon completion, SSLCommerz redirects to Laravel callbacks (`/success`, `/fail`, `/cancel`), which immediately redirect the user back to the Next.js confirmation page (`/payment/success/{tran_id}`).
