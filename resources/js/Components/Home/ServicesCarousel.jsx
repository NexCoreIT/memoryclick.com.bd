import React from 'react';
import { Link } from '@inertiajs/react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation } from 'swiper/modules';
import { resolveImageUrl } from '@/Utils/image';

export default function ServicesCarousel({
  services,
  title = 'Our Top Services',
  subtitle = 'Our Services',
}) {
  if (!services || services.length === 0) {
    return null;
  }

  return (
    <div className="service_sec pt-4 mt-4 pt-lg-5 mt-lg-5">
      <div className="container">
        <div className="text-center mx-auto mb-4" style={{ maxWidth: '600px' }}>
          <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
            {subtitle}
          </p>
          <h2 className="display-6 mb-4 fw-bold text-dark">{title}</h2>
        </div>

        <Swiper
          modules={[Navigation]}
          navigation
          loop={services.length > 3}
          spaceBetween={25}
          slidesPerView={1}
          breakpoints={{
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            992: { slidesPerView: 3 },
          }}
          className="pb-4"
        >
          {services.map((service) => (
            <SwiperSlide key={service.id}>
              <div className="testimonial-item bg-white border border-light rounded shadow-sm p-3 text-center h-100 d-flex flex-column">
                <div className="mb-3 overflow-hidden rounded shadow-sm" style={{ height: '220px' }}>
                  <img
                    src={resolveImageUrl(service.image_url || service.image)}
                    className="w-100 h-100 rounded"
                    style={{ objectFit: 'cover' }}
                    alt={service.title}
                  />
                </div>
                <div className="d-flex flex-column flex-grow-1">
                  <h5 className="mb-2 fs-5 fw-bold text-dark">
                    <strong>{service.title}</strong>
                  </h5>
                  <p className="m-0 text-muted small flex-grow-1" style={{ lineHeight: '1.6' }}>
                    {service.description?.length > 100
                      ? `${service.description.substring(0, 100)}...`
                      : service.description}
                  </p>
                  <div className="mt-3">
                    <Link
                      href={`/top-service-details/${service.slug}`}
                      className="btn btn-outline-primary btn-sm px-3 rounded"
                    >
                      Learn More
                    </Link>
                  </div>
                </div>
              </div>
            </SwiperSlide>
          ))}
        </Swiper>

        <div className="text-center mt-4">
          <Link className="btn btn-primary py-2 px-4 shadow-sm" href="/all-service">
            View All Services
          </Link>
        </div>
      </div>
    </div>
  );
}
