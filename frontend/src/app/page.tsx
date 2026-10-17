import React from "react";
import HeroSlider from "@/components/home/HeroSlider";
import StatsSection from "@/components/home/StatsSection";
import ServicesCarousel from "@/components/home/ServicesCarousel";
import LatestPackagesSection from "@/components/home/LatestPackagesSection";
import TestimonialsCarousel from "@/components/home/TestimonialsCarousel";
import RecentWorkSection from "@/components/home/RecentWorkSection";
import CinematographyCarousel from "@/components/home/CinematographyCarousel";
import HomeBlogSection from "@/components/home/HomeBlogSection";
import HomeContactSection from "@/components/home/HomeContactSection";
import { getHomeData, HomeData } from "@/lib/api";

export const revalidate = 0; // dynamic SSR

export default async function HomePage() {
  let data: HomeData | null = null;

  try {
    data = await getHomeData();
  } catch (err) {
    console.error("Error loading home page data:", err);
  }

  if (!data) {
    return (
      <div className="container py-5 text-center my-5">
        <h2 className="text-dark fw-bold mb-3">Welcome to Memory Click</h2>
        <p className="text-muted">
          Connecting to backend service... Please ensure the Laravel API server is running.
        </p>
      </div>
    );
  }

  return (
    <>
      {/* 1. Hero Sliders */}
      <HeroSlider sliders={data.sliders} />

      {/* 2. Stats / Counters & About Us Teaser */}
      <StatsSection stats={data.stats} />

      {/* 3. Top Services Carousel */}
      <ServicesCarousel
        services={data.services}
        title={data.sections.service_title}
        subtitle={data.sections.service_subtitle}
      />

      {/* 4. Latest Packages Grid with Details Modal */}
      <LatestPackagesSection
        packages={data.latest_packages}
        whatsappPhone={data.contact.phone}
      />

      {/* 5. Client Reviews Testimonial Carousel */}
      <TestimonialsCarousel
        testimonials={data.testimonials}
        title={data.sections.reviews_title}
      />

      {/* 6. Recent Wedding Photography Work */}
      <RecentWorkSection
        recentWork={data.recent_work}
        title={data.sections.recent_work_title}
        subtitle={data.sections.recent_work_subtitle}
      />

      {/* 7. Cinematography Video Carousel */}
      <CinematographyCarousel
        cinematography={data.cinematography}
        title={data.sections.cinematography_title}
        subtitle={data.sections.cinematography_subtitle}
      />

      {/* 8. Blog & Stories Insights */}
      <HomeBlogSection blogs={data.latest_blogs} />

      {/* 9. Contact Info & Message Form */}
      <HomeContactSection contact={data.contact} />
    </>
  );
}
