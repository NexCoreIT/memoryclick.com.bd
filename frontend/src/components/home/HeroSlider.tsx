"use client";

import React from "react";
import Image from "next/image";
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, EffectFade } from "swiper/modules";
import { resolveImageUrl, SliderItem } from "@/lib/api";

interface HeroSliderProps {
  sliders: SliderItem[];
}

export default function HeroSlider({ sliders }: HeroSliderProps) {
  if (!sliders || sliders.length === 0) {
    return null;
  }

  return (
    <div className="hero-header position-relative">
      <Swiper
        modules={[Autoplay, Navigation]}
        autoplay={{ delay: 5000, disableOnInteraction: false }}
        loop={sliders.length > 1}
        navigation
        className="w-100"
      >
        {sliders.map((slider, index) => (
          <SwiperSlide key={slider.id || index}>
            <div className="position-relative w-100" style={{ minHeight: "280px" }}>
              <img
                src={resolveImageUrl(slider.image_url || slider.image)}
                alt={slider.title || "Memory Click Slider"}
                className="w-100 d-block"
                style={{ objectFit: "cover", maxHeight: "650px", width: "100%" }}
              />
            </div>
          </SwiperSlide>
        ))}
      </Swiper>
    </div>
  );
}
