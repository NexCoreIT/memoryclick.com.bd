import React, { useState } from 'react';
import { Link } from '@inertiajs/react';
import { resolveImageUrl } from '@/Utils/image';
import PackageDetailsModal from './PackageDetailsModal';

export default function LatestPackagesSection({
  packages,
  whatsappPhone,
}) {
  const [selectedPackage, setSelectedPackage] = useState(null);

  if (!packages || packages.length === 0) {
    return null;
  }

  return (
    <>
      <div className="package_sec py-5 mt-4 mt-lg-5 bg-white">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
              Our Packages
            </p>
            <h2 className="display-6 mb-0 fw-bold text-dark">Explore Our Latest Packages</h2>
          </div>

          <div className="row gy-4 justify-content-center">
            {packages.map((pkg) => (
              <div key={pkg.id} className="col-md-6 col-lg-4">
                <div className="package_list text-center h-100 border p-3 rounded shadow-sm d-flex flex-column justify-content-between">
                  <div>
                    <div className="mb-3 overflow-hidden rounded" style={{ height: '200px' }}>
                      <img
                        src={resolveImageUrl(pkg.image_url || pkg.image)}
                        className="w-100 h-100 rounded"
                        style={{ objectFit: 'cover' }}
                        alt={pkg.package_name}
                      />
                    </div>
                    <h4 className="fw-bold text-dark mb-2">{pkg.package_name}</h4>
                    {pkg.team && (
                      <p className="m-0 text-muted small">{pkg.team}</p>
                    )}
                  </div>

                  <div className="d-flex mt-4 align-items-center justify-content-between pt-3 border-top">
                    <div>
                      <strong className="text-primary fs-5">
                        TK. {Number(pkg.price).toLocaleString()}
                      </strong>
                    </div>
                    <div>
                      <button
                        type="button"
                        className="btn btn-primary p-2 px-3 btn-sm shadow-sm"
                        onClick={() => setSelectedPackage(pkg)}
                      >
                        Details
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>

          <div className="text-center mt-5">
            <Link className="btn btn-primary py-2 px-4 shadow-sm" href="/package">
              View All Packages
            </Link>
          </div>
        </div>
      </div>

      {selectedPackage && (
        <PackageDetailsModal
          packageItem={selectedPackage}
          onClose={() => setSelectedPackage(null)}
          whatsappPhone={whatsappPhone}
        />
      )}
    </>
  );
}
