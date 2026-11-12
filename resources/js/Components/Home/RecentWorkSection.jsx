import React from 'react';
import { Link } from '@inertiajs/react';
import { resolveImageUrl } from '@/Utils/image';

export default function RecentWorkSection({
  recentWork,
  title = 'Our recent stunning wedding photography',
  subtitle = 'Recent Work',
}) {
  if (!recentWork || recentWork.length === 0) {
    return null;
  }

  return (
    <div className="recent_work_sec pb-5 pt-4 mt-4 pt-lg-4 mt-lg-4">
      <div className="container">
        <div className="text-center mx-auto mb-5 pb-2" style={{ maxWidth: '600px' }}>
          <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
            {subtitle}
          </p>
          <h2 className="display-6 mb-0 fw-bold text-dark">{title}</h2>
        </div>

        <div className="row gy-4">
          {recentWork.map((work) => (
            <div key={work.id} className="col-lg-6">
              <div className="row g-0 flex-sm-row border rounded overflow-hidden shadow-sm h-100 bg-white">
                <div className="col-sm-6">
                  <div className="team-img position-relative h-100" style={{ minHeight: '220px' }}>
                    <Link href={`/photography/${work.slug}`} className="d-block h-100">
                      <img
                        className="w-100 h-100"
                        src={resolveImageUrl(work.image_url || work.image)}
                        alt={work.title}
                        style={{ objectFit: 'cover' }}
                      />
                    </Link>
                  </div>
                </div>
                <div className="col-sm-6">
                  <div className="recent_work_item h-100 p-4 d-flex flex-column justify-content-between">
                    <div className="mb-3">
                      <h5 className="fw-bold mb-2 fs-6">
                        <Link
                          href={`/photography/${work.slug}`}
                          className="text-dark text-decoration-none blog-title-link"
                        >
                          {work.title}
                        </Link>
                      </h5>
                      {work.package_name && (
                        <span className="text-muted small d-block mb-1">
                          Package : <small className="fw-semibold text-primary">{work.package_name}</small>
                        </span>
                      )}
                    </div>
                    {work.client_name && (
                      <p className="text-muted small mb-0">
                        <i className="far fa-user text-primary me-1" /> {work.client_name}
                      </p>
                    )}
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
