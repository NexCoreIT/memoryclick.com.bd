import React from 'react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import { resolveImageUrl } from '@/Utils/image';

export default function ServiceDetails({ service }) {
  if (!service) return null;

  return (
    <AppLayout
      title={`${service.title} | Memory Click`}
      metaDescription={service.description?.substring(0, 160) || 'Service Details'}
    >
      <Breadcrumb
        title="All Services"
        items={[
          { label: 'All Services', href: '/all-service' },
          { label: service.title, active: true },
        ]}
      />

      <div className="service_sec section_gap py-5">
        <div className="container">
          <div className="text-center mx-auto" style={{ maxWidth: '800px' }}>
            <h1 className="display-6 mb-4 fw-bold text-dark">{service.title}</h1>
            <div className="mb-4 overflow-hidden rounded shadow-sm">
              <img
                src={resolveImageUrl(service.image_url || service.image)}
                className="img-fluid rounded w-100"
                alt={service.title}
                style={{ maxHeight: '480px', objectFit: 'cover' }}
              />
            </div>
            <p className="text-muted text-start" style={{ lineHeight: '1.9', fontSize: '1.1rem', whiteSpace: 'pre-line' }}>
              {service.description}
            </p>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
