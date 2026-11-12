import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';

export default function PaymentFail({ tran_id, order }) {
  const { props } = usePage();
  const phone = props.settings?.phone || '';
  const cleanPhone = phone.replace(/[^0-9]/g, '');

  return (
    <AppLayout title="Payment Failed | Memory Click">
      <Breadcrumb title="Payment Failed" />

      <div className="container py-5 my-4">
        <div className="row justify-content-center">
          <div className="col-md-8 col-lg-6">
            <div className="card shadow-sm border rounded-4 text-center p-4 p-md-5 bg-white">
              <div className="mb-4">
                <div
                  className="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                  style={{ width: '90px', height: '90px' }}
                >
                  <i className="fas fa-times-circle text-danger fs-1" />
                </div>
              </div>

              <h2 className="fw-bold text-dark mb-2 fs-3">Payment Failed</h2>
              <p className="text-muted mb-4 small">
                Unfortunately, your payment could not be processed. Please check your card or mobile banking balance and try again.
              </p>

              {tran_id && (
                <div className="bg-light p-3 rounded text-start mb-4 border">
                  <div className="d-flex justify-content-between">
                    <span className="text-muted small">Transaction ID:</span>
                    <span className="fw-bold text-dark small">{tran_id}</span>
                  </div>
                </div>
              )}

              <div className="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                <Link href="/package" className="btn btn-primary px-4 py-2 shadow-sm">
                  Try Again
                </Link>
                <Link href="/" className="btn btn-outline-dark px-4 py-2">
                  Back to Home
                </Link>
                {cleanPhone && (
                  <a
                    href={`https://wa.me/${cleanPhone}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn btn-dark px-3 py-2"
                  >
                    <i className="fab fa-whatsapp me-1 text-success" /> Contact Us
                  </a>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
