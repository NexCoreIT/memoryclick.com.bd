"use client";

import React from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation } from "swiper/modules";
import { CinematographyItem } from "@/lib/api";

interface CinematographyCarouselProps {
  cinematography: CinematographyItem[];
  title?: string;
  subtitle?: string;
}

function getEmbedUrl(rawUrl: string): string {
  if (!rawUrl) return "";

  if (rawUrl.includes("youtube.com/watch?v=")) {
    const videoId = rawUrl.split("watch?v=")[1]?.split("&")[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }

  if (rawUrl.includes("youtu.be/")) {
    const videoId = rawUrl.split("youtu.be/")[1]?.split("?")[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }

  // Facebook video plugin default as used in Blade template
  return `https://www.facebook.com/plugins/video.php?href=${encodeURIComponent(
    rawUrl
  )}&show_text=false&width=560`;
}

export default function CinematographyCarousel({
  cinematography,
  title = "Take a peek at our recent stunning wedding cinematography",
  subtitle = "Cinematography",
}: CinematographyCarouselProps) {
  if (!cinematography || cinematography.length === 0) {
    return null;
  }

  return (
    <div className="cinematography_sec pb-5 mb-4 pt-4 mt-4 bg-light">
      <div className="container">
        <div className="text-center mx-auto mb-4" style={{ maxWidth: "600px" }}>
          <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: "1px" }}>
            {subtitle}
          </p>
          <h2 className="display-6 mb-4 fw-bold text-dark">{title}</h2>
        </div>

        <Swiper
          modules={[Navigation]}
          navigation
          spaceBetween={25}
          slidesPerView={1}
          breakpoints={{
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
          }}
          className="pb-4"
        >
          {cinematography.map((video) => (
            <SwiperSlide key={video.id}>
              <div className="testimonial-item bg-white p-3 rounded shadow-sm border text-center h-100 d-flex flex-column">
                <div className="ratio ratio-16x9 mb-3 rounded overflow-hidden shadow-sm bg-dark">
                  <iframe
                    width="100%"
                    height="100%"
                    src={getEmbedUrl(video.youtube_url)}
                    title={video.title || "Cinematography Video"}
                    frameBorder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowFullScreen
                  />
                </div>
                <div className="flex-grow-1 d-flex flex-column justify-content-between">
                  <h5 className="mb-2 fs-6 fw-bold text-dark">
                    <strong>{video.title}</strong>
                  </h5>
                  {video.credit && (
                    <p className="m-0 text-muted small">
                      Film Credits: <span className="fw-semibold text-primary">{video.credit}</span>
                    </p>
                  )}
                </div>
              </div>
            </SwiperSlide>
          ))}
        </Swiper>
      </div>
    </div>
  );
}
