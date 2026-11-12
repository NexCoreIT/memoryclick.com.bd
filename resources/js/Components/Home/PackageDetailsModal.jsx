import React, { useEffect } from 'react';
import { Link } from '@inertiajs/react';

export default function PackageDetailsModal({
  packageItem,
  onClose,
  whatsappPhone,
}) {
  if (!packageItem) return null;

  // Lock body scroll and attach Escape key listener
  useEffect(() => {
    document.body.style.overflow = 'hidden';
    const handleKeyDown = (e) => {
      if (e.key === 'Escape') {
        onClose();
      }
    };
    window.addEventListener('keydown', handleKeyDown);
    return () => {
      document.body.style.overflow = '';
      window.removeEventListener('keydown', handleKeyDown);
    };
  }, [onClose]);

  const phone = whatsappPhone || packageItem.whatsapp_phone || '';
  const cleanPhone = phone.replace(/[^0-9]/g, '');

  return (
    <div className="modal-backdrop-custom" onClick={onClose} role="dialog" aria-modal="true">
      <div
        className="modal-dialog-custom p-4 position-relative"
        onClick={(e) => e.stopPropagation()}
      >
        <div className="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
          <h4 className="modal-title fs-5 fw-bold text-dark mb-0">
            {packageItem.package_name}
          </h4>
          <button
            type="button"
            className="btn-close shadow-none"
            aria-label="Close"
            onClick={onClose}
          />
        </div>

        <div className="modal-body text-center py-2">
          <h4 className="fw-bold text-primary mb-2">
            {packageItem.package_name}
          </h4>

          {packageItem.team && (
            <p className="text-muted fw-semibold mb-3">
              <i className="fas fa-users text-primary me-2" />
              {packageItem.team}
            </p>
          )}

          {packageItem.features && packageItem.features.length > 0 && (
            <ul className="list-unstyled text-start mx-auto my-4 bg-light p-3 rounded" style={{ maxWidth: '520px' }}>
              {packageItem.features.map((feature, idx) => (
                <li key={feature.id || idx} className="mb-2 d-flex align-items-start">
                  <i className="fas fa-check-circle text-success me-2 mt-1" />
                  <span className="text-dark small">{feature.name}</span>
                </li>
              ))}
            </ul>
          )}

          <div className="alert alert-warning text-start mx-auto p-3 small mb-4" style={{ maxWidth: '520px' }}>
            <h6 className="fw-bold mb-1 fs-6">For outside of Dhaka & Chittagong metropolitan area:</h6>
            <p className="mb-0 text-muted" style={{ fontSize: '13px' }}>
              Transportation + Accommodation & 15% shift charge (Package Price) will be added with package price.
            </p>
          </div>

          {packageItem.description && (
            <div className="package-description text-start mt-3">
              <div dangerouslySetInnerHTML={{ __html: packageItem.description }} />
            </div>
          )}
        </div>

        <div className="d-flex flex-wrap border-top pt-3 mt-3 align-items-center justify-content-between gap-3">
          <div>
            <h4 className="mb-0 fw-bold text-dark fs-5">
              TK. {Number(packageItem.price).toLocaleString()}
            </h4>
          </div>
          <div className="d-flex gap-2 align-items-center">
            {cleanPhone && (
              <a
                href={`https://wa.me/${cleanPhone}`}
                className="btn btn-sm btn-dark px-3 py-2 d-flex align-items-center gap-1 shadow-sm"
                target="_blank"
                rel="noopener noreferrer"
              >
                <i className="fab fa-whatsapp text-success" />
                <span>Contact with us</span>
              </a>
            )}

            {packageItem.ssl_status !== 0 && (
              <Link
                href={`/checkout?package_id=${packageItem.id}`}
                className="btn btn-sm btn-success d-flex align-items-center gap-2 px-3 py-2 text-white shadow-sm"
                onClick={onClose}
              >
                <img
                  src="/frontend/assets/img/sslcommerz.png"
                  alt="SSLCommerz"
                  style={{ height: '18px', width: 'auto' }}
                  onError={(e) => {
                    e.target.style.display = 'none';
                  }}
                />
                <span className="fw-semibold">Checkout</span>
              </Link>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
