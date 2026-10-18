import React from 'react';
import { Link } from '@inertiajs/react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import { resolveImageUrl } from '@/Utils/image';

export default function ServicesIndex({ services = [] }) {
  return (
    <AppLayout
      title="All Services | Memory Click"
      metaDescription="Explore all photography and cinematography services offered by Memory Click."
    >
      <Breadcrumb title="All Services" />

      <div className="service_sec section_gap py-5">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
              Services
            </p>
            <h1 className="display-6 mb-4 fw-bold text-dark">See our all services</h1>
          </div>

          <div className="row g-4">
            {services.map((service) => (
              <div key={service.id} className="col-sm-6 col-lg-4">
                <div className="bg-white border border-light h-100 rounded shadow-sm p-4 text-center d-flex flex-column justify-content-between">
                  <div>
                    <div className="mb-3 overflow-hidden rounded shadow-sm" style={{ height: '220px' }}>
                      <img
                        src={resolveImageUrl(service.image_url || service.image)}
                        className="w-100 h-100 rounded"
                        style={{ objectFit: 'cover' }}
                        alt={service.title}
                      />
                    </div>
                    <h5 className="mb-3 fs-5 fw-bold text-dark">
                      <strong>{service.title}</strong>
                    </h5>
                    <p className="m-0 text-muted small" style={{ lineHeight: '1.7' }}>
                      {service.description?.length > 100
                        ? `${service.description.substring(0, 100)}...`
                        : service.description}
                    </p>
                  </div>

                  <div className="mt-4">
                    <Link
                      className="d-inline-block bg-primary py-2 px-4 text-white rounded text-decoration-none fw-semibold shadow-sm"
                      href={`/top-service-details/${service.slug}`}
                    >
                      Read More
                    </Link>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
