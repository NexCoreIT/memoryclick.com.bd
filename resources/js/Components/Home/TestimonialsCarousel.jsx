import React, { useState } from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation } from 'swiper/modules';
import { resolveImageUrl } from '@/Utils/image';

export default function TestimonialsCarousel({
  testimonials,
  title = 'Client Reviews',
}) {
  const [expandedIds, setExpandedIds] = useState({});

  const toggleExpand = (id) => {
    setExpandedIds((prev) => ({
      ...prev,
      [id]: !prev[id],
    }));
  };

  if (!testimonials || testimonials.length === 0) {
    return null;
  }

  return (
    <div className="bg-light reviews py-5 mt-4 mt-lg-5">
      <div className="container">
        <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
          <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
            Client Reviews
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
            992: { slidesPerView: 3 },
          }}
          className="pb-4"
        >
          {testimonials.map((item) => {
            const isExpanded = !!expandedIds[item.id];
            const isLong = item.description?.length > 150;
            const displayText = isLong && !isExpanded
              ? `${item.description.substring(0, 150)}...`
              : item.description;

            return (
              <SwiperSlide key={item.id}>
                <div className="testimonial-item bg-white p-4 rounded shadow-sm border h-100 d-flex flex-column text-start">
                  <div className="d-flex align-items-center mb-3">
                    <img
                      className="flex-shrink-0 rounded-circle border p-1"
                      width={80}
                      height={80}
                      src={resolveImageUrl(item.image_url || item.image)}
                      alt={item.name}
                      style={{ objectFit: 'cover' }}
                    />
                    <div className="ms-3">
                      <h5 className="mb-1 fw-bold text-dark fs-6">{item.name}</h5>
                      <span className="text-muted small">{item.designation}</span>
                    </div>
                  </div>

                  {/* Rating Stars */}
                  <div className="mb-3 text-warning">
                    {[1, 2, 3, 4, 5].map((star) => (
                      <i
                        key={star}
                        className={`fa fa-star small me-1 ${
                          star <= item.rating ? 'text-primary' : 'text-muted opacity-25'
                        }`}
                      />
                    ))}
                  </div>

                  <div className="flex-grow-1">
                    <p className="mb-0 text-muted small" style={{ lineHeight: '1.7' }}>
                      {displayText}{' '}
                      {isLong && (
                        <button
                          type="button"
                          className="btn btn-link p-0 text-primary fw-bold text-decoration-none small align-baseline shadow-none"
                          onClick={() => toggleExpand(item.id)}
                        >
                          {isExpanded ? 'Show less' : 'Learn more'}
                        </button>
                      )}
                    </p>
                  </div>
                </div>
              </SwiperSlide>
            );
          })}
        </Swiper>
      </div>
    </div>
  );
}
