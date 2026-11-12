import React, { useState } from 'react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import Lightbox from 'yet-another-react-lightbox';
import { resolveImageUrl } from '@/Utils/image';

export default function PhotographyDetails({
  id,
  title,
  slug,
  client_name,
  package_name,
  image,
  image_url,
  gallery_images = [],
  category,
}) {
  const [lightboxOpen, setLightboxOpen] = useState(false);
  const [lightboxIndex, setLightboxIndex] = useState(0);

  const heroImage = resolveImageUrl(image_url || image);
  const slides = gallery_images.map((img, idx) => ({
    src: resolveImageUrl(img.url || img.path),
    alt: `${title} - Photo ${idx + 1}`,
  }));

  const openLightboxAt = (idx) => {
    setLightboxIndex(idx);
    setLightboxOpen(true);
  };

  return (
    <AppLayout
      title={`${title} | Memory Click`}
      metaDescription={`Photography session: ${title} for ${client_name || 'Client'}`}
    >
      <Breadcrumb
        title={title}
        items={[
          { label: 'Photography', href: '/photography' },
          { label: title, active: true },
        ]}
      />

      {/* Hero Section */}
      <div className="hero-header pb-4 bg-white border-bottom">
        <div className="container py-4">
          <div className="row justify-content-center">
            <div className="col-lg-10 text-center">
              <div className="mb-4 overflow-hidden rounded shadow-sm" style={{ maxHeight: '520px' }}>
                <img
                  src={heroImage}
                  className="img-fluid rounded w-100"
                  alt={title}
                  style={{ objectFit: 'cover' }}
                />
              </div>

              <h1 className="display-5 my-3 fw-bold text-dark">{title}</h1>
              {client_name && (
                <p className="text-primary fw-bold mb-1 fs-5">{client_name}</p>
              )}
              {category?.name && (
                <p className="mb-1 text-muted small">{category.name}</p>
              )}
              {package_name && (
                <p className="mb-0 text-muted small">
                  Package: <span className="fw-semibold text-dark">{package_name}</span>
                </p>
              )}
            </div>
          </div>
        </div>
      </div>

      {/* Gallery Section */}
      <div className="cinematography_sec section_gap py-5 bg-light">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
              Gallery
            </p>
            <h3 className="display-6 fw-bold text-dark">View More Photos</h3>
          </div>

          {gallery_images.length === 0 ? (
            <div className="text-center py-5">
              <div className="bg-white p-4 rounded shadow-sm border mx-auto" style={{ maxWidth: '500px' }}>
                <p className="text-muted fw-semibold mb-0">No additional gallery photos found for this shoot.</p>
              </div>
            </div>
          ) : (
            <div className="row gy-4">
              {gallery_images.map((img, idx) => (
                <div key={idx} className="col-lg-4 col-md-6 col-sm-6">
                  <div
                    className="position-relative overflow-hidden rounded shadow-sm mb-2 bg-white p-2 border"
                    style={{ height: '280px', cursor: 'pointer' }}
                    onClick={() => openLightboxAt(idx)}
                  >
                    <img
                      src={resolveImageUrl(img.url || img.path)}
                      className="w-100 h-100 rounded"
                      alt={`${title} - ${idx + 1}`}
                      style={{ objectFit: 'cover', transition: 'transform 0.4s ease' }}
                    />
                    <div
                      className="position-absolute top-0 end-0 p-2 m-3 bg-dark bg-opacity-50 text-white rounded-circle d-flex align-items-center justify-content-center"
                      style={{ width: '34px', height: '34px' }}
                      title="Click to view full photo"
                    >
                      <i className="fas fa-search-plus small" />
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </div>

      <Lightbox
        open={lightboxOpen}
        close={() => setLightboxOpen(false)}
        index={lightboxIndex}
        slides={slides}
      />
    </AppLayout>
  );
}
