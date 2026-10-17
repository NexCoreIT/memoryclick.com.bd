const API_BASE_URL =
  process.env.NEXT_PUBLIC_API_URL ||
  "http://localhost/MyProjects/memoryclick.com.bd/public/api";

const BACKEND_BASE_URL =
  process.env.NEXT_PUBLIC_BACKEND_URL ||
  "http://localhost/MyProjects/memoryclick.com.bd/public";

/**
 * Ensures an image path resolves to a valid full URL.
 */
export function resolveImageUrl(path?: string | null): string {
  if (!path) return "/fav.png";
  if (path.startsWith("http://") || path.startsWith("https://") || path.startsWith("//")) {
    return path;
  }
  const cleanPath = path.startsWith("/") ? path : `/${path}`;
  return `${BACKEND_BASE_URL}${cleanPath}`;
}

/**
 * Generic API request helper.
 */
async function fetchApi<T>(
  endpoint: string,
  options?: RequestInit
): Promise<T> {
  const url = `${API_BASE_URL}${endpoint.startsWith("/") ? endpoint : `/${endpoint}`}`;

  try {
    const res = await fetch(url, {
      ...options,
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        ...(options?.headers || {}),
      },
      next: { revalidate: 0 }, // dynamically fetch fresh data or SSR
    });

    const data = await res.json();

    if (!res.ok) {
      throw new Error(data.message || `API request failed with status ${res.status}`);
    }

    return data.data !== undefined ? data.data : data;
  } catch (error: any) {
    console.error(`Error fetching ${endpoint}:`, error);
    throw error;
  }
}

// ==========================================
// TYPE DEFINITIONS
// ==========================================

export interface SiteSettings {
  site_title: string;
  meta_title: string;
  meta_description: string;
  meta_keywords: string;
  meta_image_url: string;
  logo_url: string;
  favicon_url: string;
  phone: string;
  email: string;
  address: string;
  google_map?: string;
  footer_title?: string;
  facebook_link?: string;
  youtube_link?: string;
  instagram_link?: string;
  ssl_status?: number;
  google_search_console_code?: string;
  google_analytics_id?: string;
  google_analytics_code?: string;
  google_pixel_id?: string;
  google_pixel_code?: string;
  custom_head_code?: string;
  custom_body_code?: string;
}

export interface SliderItem {
  id: number;
  title?: string | null;
  image: string;
  image_url: string;
  sort_number?: string | number;
}

export interface ServiceItem {
  id: number;
  title: string;
  slug: string;
  description: string;
  image: string;
  image_url: string;
}

export interface PackageFeature {
  id: number;
  name: string;
}

export interface PackageItem {
  id: number;
  package_name: string;
  slug?: string;
  price: number;
  team?: string;
  chief?: string;
  photographer?: string;
  cinematographer?: string;
  image?: string;
  image_url?: string;
  description?: string;
  category_id?: number;
  division?: { id: number; name: string; slug: string } | null;
  category?: { id: number; name: string; slug: string } | null;
  features: PackageFeature[];
  ssl_status?: number;
  whatsapp_phone?: string;
  outside_charge_notice?: string;
}

export interface TestimonialItem {
  id: number;
  name: string;
  designation: string;
  description: string;
  rating: number;
  image: string;
  image_url: string;
}

export interface RecentWorkItem {
  id: number;
  title: string;
  slug: string;
  client_name?: string;
  package_name?: string;
  image: string;
  image_url: string;
}

export interface CinematographyItem {
  id: number;
  title: string;
  youtube_url: string;
  credit?: string;
}

export interface BlogItem {
  id: number;
  title: string;
  slug: string;
  short_description?: string;
  description?: string;
  author_name?: string;
  created_at?: string;
  created_at_iso?: string;
  updated_at_iso?: string;
  views: number;
  image?: string;
  image_url?: string;
  category?: { id: number; name: string; slug: string } | null;
}

export interface BlogCategoryItem {
  id: number;
  name: string;
  slug: string;
  posts_count: number;
}

export interface DivisionItem {
  id: number;
  name: string;
  slug: string;
  image?: string;
  image_url?: string;
  packages_count: number;
}

export interface HomeData {
  sliders: SliderItem[];
  stats: {
    since_year: string;
    events_count: string;
    photos_count: string;
    clients_count: string;
    about_title: string;
    about_content: string;
  };
  services: ServiceItem[];
  latest_packages: PackageItem[];
  testimonials: TestimonialItem[];
  recent_work: RecentWorkItem[];
  cinematography: CinematographyItem[];
  latest_blogs: BlogItem[];
  sections: {
    service_title: string;
    service_subtitle: string;
    recent_work_title: string;
    recent_work_subtitle: string;
    cinematography_title: string;
    cinematography_subtitle: string;
    reviews_title: string;
  };
  contact: {
    phone: string;
    email: string;
    address: string;
    google_map?: string;
  };
}

export interface AboutData {
  meta_title: string;
  meta_description: string;
  meta_keywords: string;
  ceo_name: string;
  ceo_designation: string;
  ceo_image_url: string;
  ceo_body: string;
  title_2: string;
  memoryclick_image_url: string;
  about_memoryclick: string;
  teams: Array<{
    id: number;
    name: string;
    slug?: string;
    designation: string;
    image: string;
    image_url: string;
  }>;
}

export interface CustomPageData {
  id: number | null;
  title: string;
  slug: string;
  body: string;
  meta_title?: string;
  meta_description?: string;
  meta_keywords?: string;
}

// ==========================================
// API CALL FUNCTIONS
// ==========================================

export async function getSettings(): Promise<SiteSettings> {
  return fetchApi<SiteSettings>("/settings");
}

export async function getHomeData(): Promise<HomeData> {
  return fetchApi<HomeData>("/home");
}

export async function getAboutData(): Promise<AboutData> {
  return fetchApi<AboutData>("/about");
}

export async function getServices(): Promise<ServiceItem[]> {
  return fetchApi<ServiceItem[]>("/services");
}

export async function getServiceDetails(slug: string): Promise<ServiceItem> {
  return fetchApi<ServiceItem>(`/services/${slug}`);
}

export async function getPhotography(): Promise<{
  categories: Array<{ id: number; name: string; slug: string }>;
  items: Array<{
    id: number;
    title: string;
    slug: string;
    client_name?: string;
    package_name?: string;
    image: string;
    image_url: string;
    category?: { id: number; name: string; slug: string } | null;
  }>;
}> {
  return fetchApi("/photography");
}

export async function getPhotographyDetails(slug: string): Promise<{
  id: number;
  title: string;
  slug: string;
  client_name?: string;
  package_name?: string;
  image: string;
  image_url: string;
  gallery_images: Array<{ path: string; url: string }>;
  category?: { id: number; name: string; slug: string } | null;
}> {
  return fetchApi(`/photography/${slug}`);
}

export async function getCinematography(): Promise<CinematographyItem[]> {
  return fetchApi<CinematographyItem[]>("/cinematography");
}

export async function getPackageDivisions(): Promise<DivisionItem[]> {
  return fetchApi<DivisionItem[]>("/packages/divisions");
}

export async function getDivisionPackages(slug: string): Promise<{
  division: { id: number; name: string; slug: string; image_url: string };
  categories: Array<{ id: number; name: string; slug: string }>;
  packages: PackageItem[];
}> {
  return fetchApi(`/packages/division/${slug}`);
}

export async function getPackageDetails(id: string | number): Promise<PackageItem> {
  return fetchApi<PackageItem>(`/packages/${id}`);
}

export async function getBlogs(params?: {
  category?: string;
  search?: string;
  page?: number;
  per_page?: number;
}): Promise<{
  categories: BlogCategoryItem[];
  posts: BlogItem[];
  pagination: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
  selected_category?: string;
  search_query?: string;
}> {
  const query = new URLSearchParams();
  if (params?.category) query.set("category", params.category);
  if (params?.search) query.set("search", params.search);
  if (params?.page) query.set("page", params.page.toString());
  if (params?.per_page) query.set("per_page", params.per_page.toString());

  const queryString = query.toString();
  return fetchApi(`/blogs${queryString ? `?${queryString}` : ""}`);
}

export async function getBlogDetails(slug: string): Promise<{
  post: BlogItem;
  seo: {
    meta_title: string;
    meta_description: string;
    meta_keywords: string;
    meta_image_url: string;
  };
  categories: BlogCategoryItem[];
  related_posts: BlogItem[];
}> {
  return fetchApi(`/blogs/${slug}`);
}

export async function getCustomPage(slug: string): Promise<CustomPageData> {
  return fetchApi<CustomPageData>(`/page/${slug}`);
}

export async function submitContact(data: {
  name: string;
  email: string;
  subject: string;
  message: string;
}): Promise<{ status: string; message: string; data: { id: number } }> {
  const url = `${API_BASE_URL}/contact`;
  const res = await fetch(url, {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });
  const json = await res.json();
  if (!res.ok) {
    throw new Error(json.message || "Failed to submit message");
  }
  return json;
}

export async function initiatePayment(data: {
  package_id: number;
  name: string;
  email: string;
  phone: string;
  address: string;
  city: string;
  state?: string;
  postcode?: string;
  country: string;
}): Promise<{ gateway_url: string; tran_id: string; order_id: number }> {
  const url = `${API_BASE_URL}/checkout/pay`;
  const res = await fetch(url, {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });
  const json = await res.json();
  if (!res.ok || json.status !== "success") {
    throw new Error(json.message || "Failed to initiate payment");
  }
  return json.data;
}

export async function getOrderDetails(tran_id: string): Promise<{
  id: number;
  tran_id: string;
  name: string;
  email: string;
  phone: string;
  amount: number;
  currency: string;
  status: string;
  created_at: string;
  package?: { id: number; package_name: string; price: number } | null;
}> {
  return fetchApi(`/order/${tran_id}`);
}
