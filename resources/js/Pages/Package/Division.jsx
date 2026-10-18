import React, { useState } from 'react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import PackageDetailsModal from '@/Components/Home/PackageDetailsModal';
import { resolveImageUrl } from '@/Utils/image';

export default function DivisionPackages({
  division = {},
  categories = [],
  packages = [],
  whatsappPhone,
}) {
  const [selectedCategory, setSelectedCategory] = useState('all');
  const [modalPackage, setModalPackage] = useState(null);

  const filteredPackages = selectedCategory === 'all'
    ? packages
    : packages.filter((pkg) => pkg.category_id === selectedCategory);

  return (
    <AppLayout
      title={`${division?.name || 'Division'} Packages | Memory Click`}
      metaDescription={`Explore photography and cinematography packages available in ${division?.name || 'Bangladesh'}.`}
    >
      <Breadcrumb
        title={`${division?.name || 'Division'} Packages`}
        items={[
          { label: 'Packages', href: '/package' },
          { label: `${division?.name || 'Division'} Packages`, active: true },
        ]}
      />

      <div className="package_sec section_gap py-5">
        <div className="container">
          <div className="text-center mb-5">
            <h2 className="display-6 fw-bold text-dark">
              Packages For <strong className="text-primary">{division?.name}</strong>
            </h2>
          </div>

          <div className="row">
            {/* Sidebar Category Filter */}
            <div className="col-lg-3 col-xl-2 border-end mb-4 mb-lg-0">
              <div className="package_category pe-lg-3">
                <button
                  type="button"
                  className={`btn btn-default shadow-none border-0 w-100 text-start bg-transparent filter-button py-2 ${
                    selectedCategory === 'all' ? 'active' : 'text-muted'
                  }`}
                  onClick={() => setSelectedCategory('all')}
                >
                  All
                </button>
                {categories.map((cat) => (
                  <button
                    key={cat.id}
                    type="button"
                    className={`btn btn-default shadow-none border-0 w-100 text-start bg-transparent filter-button py-2 ${
                      selectedCategory === cat.id ? 'active' : 'text-muted'
                    }`}
                    onClick={() => setSelectedCategory(cat.id)}
                  >
                    {cat.name}
                  </button>
                ))}
              </div>
            </div>

            {/* Packages Grid */}
            <div className="col-lg-9 col-xl-10">
              {filteredPackages.length === 0 ? (
                <div className="text-center py-5 bg-light rounded">
                  <p className="text-muted fw-semibold mb-0">
                    No packages available in this category for {division?.name}.
                  </p>
                </div>
              ) : (
                <div className="row gy-4">
                  {filteredPackages.map((pkg) => (
                    <div key={pkg.id} className="col-sm-6 col-xl-4">
                      <div className="package_list text-center h-100 border p-3 rounded shadow-sm bg-white d-flex flex-column justify-content-between">
                        <div>
                          <div className="mb-3 overflow-hidden rounded" style={{ height: '190px' }}>
                            <img
                              src={resolveImageUrl(pkg.image_url || pkg.image)}
                              className="w-100 h-100 rounded"
                              style={{ objectFit: 'cover' }}
                              alt={pkg.package_name}
                            />
                          </div>
                          <h4 className="fw-bold text-dark mb-2 fs-5">
                            {pkg.package_name}
                          </h4>
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
                              onClick={() => setModalPackage(pkg)}
                            >
                              Details
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>
          </div>
        </div>
      </div>

      {modalPackage && (
        <PackageDetailsModal
          packageItem={modalPackage}
          onClose={() => setModalPackage(null)}
          whatsappPhone={whatsappPhone}
        />
      )}
    </AppLayout>
  );
}
