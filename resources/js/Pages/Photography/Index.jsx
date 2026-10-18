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

      <div className="cinematography_sec section_gap py-5">
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
              className={`btn btn-default shadow-none border-0 bg-transparent filter-button px-3 py-2 ${
                selectedFilter === 'all' ? 'active' : 'text-muted'
              }`}
              onClick={() => setSelectedFilter('all')}
            >
              All
            </button>
            {categories.map((cat) => (
              <button
                key={cat.id}
                type="button"
                className={`btn btn-default shadow-none border-0 bg-transparent filter-button px-3 py-2 ${
                  selectedFilter === cat.slug ? 'active' : 'text-muted'
                }`}
                onClick={() => setSelectedFilter(cat.slug)}
              >
                {cat.name}
              </button>
            ))}
          </div>

          {/* Photos Grid */}
          <div className="gallery row gy-4">
            {filteredItems.map((item, index) => (
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
                      style={{ width: '32px', height: '32px' }}
                    >
                      <i className="fas fa-search-plus small" />
                    </div>
                  </div>

                  <div>
                    <h5 className="fw-bold mb-1 fs-6">
                      <Link
                        href={`/photography/${item.slug}`}
                        className="text-dark text-decoration-none"
                      >
                        {item.title}
                      </Link>
                    </h5>
                    <p className="m-0 text-muted small">{item.category?.name}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>

      {lightboxOpen && (
        <Lightbox
          open={lightboxOpen}
          close={() => setLightboxOpen(false)}
          index={lightboxIndex}
          slides={slides}
        />
      )}
    </AppLayout>
  );
}
