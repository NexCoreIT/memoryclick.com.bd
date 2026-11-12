import React, { useState } from 'react';
import { Link } from '@inertiajs/react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import Lightbox from 'yet-another-react-lightbox';
import { resolveImageUrl } from '@/Utils/image';

export default function PhotographyIndex({
  categories = [],
  items = [],
}) {
  const [selectedFilter, setSelectedFilter] = useState('all');
  const [lightboxOpen, setLightboxOpen] = useState(false);
  const [lightboxIndex, setLightboxIndex] = useState(0);

  const filteredItems = selectedFilter === 'all'
    ? items
    : items.filter((item) => item.category?.slug === selectedFilter);

  const slides = filteredItems.map((item) => ({
    src: resolveImageUrl(item.image_url || item.image),
    alt: item.title,
  }));

  const openLightboxAt = (index) => {
    setLightboxIndex(index);
    setLightboxOpen(true);
  };

  return (
    <AppLayout
      title="Photography Portfolio | Memory Click"
      metaDescription="Browse our wedding photography portfolio across Bangladesh."
    >
      <Breadcrumb title="Photography" />

      <div className="cinematography_sec section_gap py-5 bg-white">
        <div className="container">
          <div className="text-center mx-auto mb-4" style={{ maxWidth: '600px' }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
              Photography
            </p>
            <h1 className="display-6 mb-4 fw-bold text-dark">See our all Photography</h1>
          </div>

          {/* Filter Bar */}
          <div className="text-center mb-5 d-flex flex-wrap justify-content-center gap-2">
            <button
              type="button"
              className={`filter-button ${
                selectedFilter === 'all' ? 'active' : ''
              }`}
              onClick={() => setSelectedFilter('all')}
            >
              All
            </button>
            {categories.map((cat) => (
              <button
                key={cat.id}
                type="button"
                className={`filter-button ${
                  selectedFilter === cat.slug ? 'active' : ''
                }`}
                onClick={() => setSelectedFilter(cat.slug)}
              >
                {cat.name}
              </button>
            ))}
          </div>

          {/* Photos Grid */}
          <div className="gallery row gy-4">
            {filteredItems.length === 0 ? (
              <div className="col-12 text-center py-5">
                <div className="bg-light p-5 rounded shadow-sm border mx-auto" style={{ maxWidth: '500px' }}>
                  <i className="fas fa-camera fa-3x text-primary mb-3" />
                  <h4 className="fw-bold mb-2">No Photos Found</h4>
                  <p className="text-muted small mb-0">No photography albums found in this category.</p>
                </div>
              </div>
            ) : (
              filteredItems.map((item, index) => (
                <div key={item.id} className="gallery_product col-lg-4 col-md-6 col-sm-6">
                  <div className="photograpy_item text-center bg-white p-3 rounded shadow-sm border h-100 d-flex flex-column justify-content-between">
                    <div
                      className="position-relative overflow-hidden rounded mb-3"
                      style={{ height: '260px', cursor: 'pointer' }}
                      onClick={() => openLightboxAt(index)}
                    >
                      <img
                        src={resolveImageUrl(item.image_url || item.image)}
                        className="w-100 h-100 rounded"
                        alt={item.title}
                        style={{ objectFit: 'cover', transition: 'transform 0.4s ease' }}
                      />
                      <div
                        className="position-absolute top-0 end-0 p-2 m-2 bg-dark bg-opacity-50 text-white rounded-circle d-flex align-items-center justify-content-center"
                        style={{ width: '34px', height: '34px' }}
                        title="Click to zoom preview"
                      >
                        <i className="fas fa-search-plus small" />
                      </div>
                    </div>

                    <div>
                      <h5 className="fw-bold mb-1 fs-6">
                        <Link
                          href={`/photography/${item.slug}`}
                          className="text-dark text-decoration-none blog-title-link"
                        >
                          {item.title || 'Photography Album'}
                        </Link>
                      </h5>
                      {item.category?.name && (
                        <p className="m-0 text-muted small">{item.category.name}</p>
                      )}
                    </div>
                  </div>
                </div>
              ))
            )}
          </div>
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
