import React from 'react';
import { Link } from '@inertiajs/react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import { resolveImageUrl } from '@/Utils/image';

export default function PackageIndex({ divisions = [] }) {
  return (
    <AppLayout
      title="Packages | Memory Click"
      metaDescription="Browse our photography and cinematography packages by division in Bangladesh."
    >
      <Breadcrumb title="Packages" />

      <div className="section_gap py-5 bg-white">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
              Divisions
            </p>
            <h1 className="display-6 mb-3 fw-bold text-dark">Select Your Event Location</h1>
            <p className="text-muted small">
              Choose your division to explore tailored photography & cinematography packages.
            </p>
          </div>

          <div className="row justify-content-center">
            <div className="col-lg-8">
              <div className="row gy-4">
                {divisions.map((division) => (
                  <div key={division.id} className="col-md-6">
                    <div className="package_wrap h-100 text-center position-relative overflow-hidden border rounded shadow-sm bg-white p-3">
                      <div className="overflow-hidden rounded-top mb-3" style={{ height: '230px' }}>
                        <img
                          src={resolveImageUrl(division.image_url || division.image)}
                          className="w-100 h-100 rounded-top"
                          alt={division.name}
                          style={{ objectFit: 'cover', transition: 'transform 0.4s ease' }}
                        />
                      </div>
                      <h4 className="fw-bold mb-2 fs-5">
                        <Link
                          href={`/division/${division.slug}/package`}
                          className="stretched-link text-decoration-none text-dark"
                        >
                          {division.name} Packages
                        </Link>
                      </h4>
                      <p className="text-muted small mb-0">
                        {division.packages_count ?? (division.packages ? division.packages.length : 0)} Available Packages
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
