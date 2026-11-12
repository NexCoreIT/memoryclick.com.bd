import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';

export default function PaymentSuccess({ tran_id, order }) {
  const { props } = usePage();
  const phone = props.settings?.phone || '';
  const cleanPhone = phone.replace(/[^0-9]/g, '');

  return (
    <AppLayout
      title="Payment Successful | Memory Click"
      metaDescription="Your wedding photography booking has been confirmed."
    >
      <Breadcrumb title="Payment Completed" />

      <div className="container py-5 my-4">
        <div className="row justify-content-center">
          <div className="col-md-8 col-lg-6">
            <div className="card shadow-sm border rounded-4 text-center p-4 p-md-5 bg-white">
              <div className="mb-4">
                <div
                  className="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                  style={{ width: '90px', height: '90px' }}
                >
                  <i className="fas fa-check-circle text-success fs-1" />
                </div>
              </div>

              <h2 className="fw-bold text-dark mb-2 fs-3">Payment Successful!</h2>
              <p className="text-muted mb-4 small">
                Thank you for choosing MemoryClick. Your booking transaction has been confirmed.
              </p>

              <div className="bg-light p-4 rounded text-start mb-4 border">
                <div className="d-flex justify-content-between mb-2">
                  <span className="text-muted small">Transaction ID:</span>
                  <span className="fw-bold text-dark small">{tran_id || order?.tran_id}</span>
                </div>
                {order?.package && (
                  <div className="d-flex justify-content-between mb-2">
                    <span className="text-muted small">Package:</span>
                    <span className="fw-semibold text-dark small">
                      {order.package.package_name}
                    </span>
                  </div>
                )}
                {order?.amount && (
                  <div className="d-flex justify-content-between mb-2">
                    <span className="text-muted small">Amount Paid:</span>
                    <span className="fw-bold text-success small">
                      TK. {Number(order.amount).toLocaleString()}
                    </span>
                  </div>
                )}
                {order?.name && (
                  <div className="d-flex justify-content-between mb-2">
                    <span className="text-muted small">Customer Name:</span>
                    <span className="text-dark small">{order.name}</span>
                  </div>
                )}
                {order?.email && (
                  <div className="d-flex justify-content-between mb-2">
                    <span className="text-muted small">Confirmation Sent To:</span>
                    <span className="text-dark small">{order.email}</span>
                  </div>
                )}
                <div className="d-flex justify-content-between">
                  <span className="text-muted small">Payment Status:</span>
                  <span className="badge bg-success">Completed</span>
                </div>
              </div>

              <div className="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                <Link href="/" className="btn btn-primary px-4 py-2 shadow-sm">
                  Back to Home
                </Link>
                <Link href="/package" className="btn btn-outline-dark px-4 py-2">
                  Browse More Packages
                </Link>
                {cleanPhone && (
                  <a
                    href={`https://wa.me/${cleanPhone}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn btn-dark px-3 py-2"
                  >
                    <i className="fab fa-whatsapp me-1 text-success" /> WhatsApp
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
