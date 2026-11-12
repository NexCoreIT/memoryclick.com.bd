import React from 'react';
import { Link } from '@inertiajs/react';

export default function StatsSection({ stats }) {
  if (!stats) return null;

  return (
    <div className="about_sec pt-4 mt-4 pt-lg-5 mt-lg-5">
      <div className="container">
        <div className="row align-items-center">
          <div className="col-lg-6">
            <div className="row">
              <div className="col-6 mb-3">
                <div className="count_items bg-light p-3 p-lg-4 rounded text-center h-100 shadow-sm border border-light">
                  <h5 className="text-dark fs-6 mb-2">Since</h5>
                  <h2 className="fs-1 fw-bold text-primary mb-0">
                    {stats.since_year || '2014'}
                  </h2>
                </div>
              </div>
              <div className="col-6 mb-3">
                <div className="count_items bg-light p-3 p-lg-4 rounded text-center h-100 shadow-sm border border-light">
                  <h5 className="text-dark fs-6 mb-2">Events</h5>
                  <h2 className="fs-1 fw-bold text-primary mb-0">
                    <span>{stats.events_count || '3000'}</span> +
                  </h2>
                </div>
              </div>
              <div className="col-6 mb-3">
                <div className="count_items bg-light p-3 p-lg-4 rounded text-center h-100 shadow-sm border border-light">
                  <h5 className="text-dark fs-6 mb-2">Photos</h5>
                  <h2 className="fs-1 fw-bold text-primary mb-0">
                    <span>{stats.photos_count || '1000'}</span> k+
                  </h2>
                </div>
              </div>
              <div className="col-6 mb-3">
                <div className="count_items bg-light p-3 p-lg-4 rounded text-center h-100 shadow-sm border border-light">
                  <h5 className="text-dark fs-6 mb-2">Clients</h5>
                  <h2 className="fs-1 fw-bold text-primary mb-0">
                    <span>{stats.clients_count || '999'}</span> k+
                  </h2>
                </div>
              </div>
            </div>
          </div>

          <div className="col-lg-6 mt-4 mt-lg-0">
            <div className="ps-lg-4">
              <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
                About Us
              </p>
              <h1 className="title mb-4 fw-bold text-dark">
                {stats.about_title || 'About MemoryClick'}
              </h1>
              <p className="mb-4 text-muted" style={{ lineHeight: '1.8', fontSize: '1.05rem' }}>
                {stats.about_content || 'Premium wedding photography and cinematography company based in Bangladesh.'}
              </p>

              <Link className="btn btn-primary py-2 px-4 shadow-sm" href="/about">
                Read More
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
