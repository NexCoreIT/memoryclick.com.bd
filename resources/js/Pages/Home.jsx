import React from 'react';
import AppLayout from '@/Components/Layout/AppLayout';
import HeroSlider from '@/Components/Home/HeroSlider';
import StatsSection from '@/Components/Home/StatsSection';
import ServicesCarousel from '@/Components/Home/ServicesCarousel';
import LatestPackagesSection from '@/Components/Home/LatestPackagesSection';
import TestimonialsCarousel from '@/Components/Home/TestimonialsCarousel';
import RecentWorkSection from '@/Components/Home/RecentWorkSection';
import CinematographyCarousel from '@/Components/Home/CinematographyCarousel';
import HomeBlogSection from '@/Components/Home/HomeBlogSection';
import HomeContactSection from '@/Components/Home/HomeContactSection';

export default function Home({
  sliders = [],
  stats = {},
  services = [],
  latest_packages = [],
  testimonials = [],
  recent_work = [],
  cinematography = [],
  latest_blogs = [],
  sections = {},
  contact = {},
}) {
  return (
    <AppLayout title="Memory Click | Best Wedding Photographer in Bangladesh">
      {/* 1. Hero Sliders */}
      <HeroSlider sliders={sliders} />

      {/* 2. Stats / Counters & About Us Teaser */}
      <StatsSection stats={stats} />

      {/* 3. Top Services Carousel */}
      <ServicesCarousel
        services={services}
        title={sections?.service_title}
        subtitle={sections?.service_subtitle}
      />

      {/* 4. Latest Packages Grid with Details Modal */}
      <LatestPackagesSection
        packages={latest_packages}
        whatsappPhone={contact?.phone}
      />

      {/* 5. Client Reviews Testimonial Carousel */}
      <TestimonialsCarousel
        testimonials={testimonials}
        title={sections?.reviews_title}
      />

      {/* 6. Recent Wedding Photography Work */}
      <RecentWorkSection
        recentWork={recent_work}
        title={sections?.recent_work_title}
        subtitle={sections?.recent_work_subtitle}
      />

      {/* 7. Cinematography Video Carousel */}
      <CinematographyCarousel
        cinematography={cinematography}
        title={sections?.cinematography_title}
        subtitle={sections?.cinematography_subtitle}
      />

      {/* 8. Blog & Stories Insights */}
      <HomeBlogSection blogs={latest_blogs} />

      {/* 9. Contact Info & Message Form */}
      <HomeContactSection contact={contact} />
    </AppLayout>
  );
}
