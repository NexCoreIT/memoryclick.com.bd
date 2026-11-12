import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import axios from 'axios';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';

export default function Checkout({ packageItem }) {
  const { props } = usePage();
  const whatsappPhone = props.settings?.phone || '';

  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    country: 'Bangladesh',
    address: '',
    city: '',
    state: '',
    postcode: '',
  });

  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState('');

  if (!packageItem) {
    return (
      <AppLayout title="Checkout | Memory Click">
        <Breadcrumb title="Checkout" />
        <div className="container py-5 text-center my-5">
          <div className="bg-white p-5 rounded shadow-sm border mx-auto" style={{ maxWidth: '500px' }}>
            <i className="fas fa-shopping-cart fa-3x text-primary mb-3" />
            <h4 className="fw-bold mb-2 text-dark">No Package Selected</h4>
            <p className="text-muted small mb-4">
              Please choose a photography or cinematography package to proceed to checkout.
            </p>
            <Link href="/package" className="btn btn-primary px-4 py-2 shadow-sm">
              Browse Packages
            </Link>
          </div>
        </div>
      </AppLayout>
    );
  }

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrorMsg('');

    try {
      const res = await axios.post('/api/checkout/pay', {
        package_id: packageItem.id,
        ...formData,
      });

      if (res.data?.data?.gateway_url) {
        window.location.href = res.data.data.gateway_url;
      } else {
        throw new Error('Payment gateway URL not received. Please try again.');
      }
    } catch (err) {
      setErrorMsg(err.response?.data?.message || err.message || 'Failed to initiate payment.');
      setLoading(false);
    }
  };

  const cleanPhone = (whatsappPhone || packageItem.whatsapp_phone || '880').replace(
    /[^0-9]/g,
    ''
  );

  return (
    <AppLayout
      title="Checkout | Memory Click"
      metaDescription="Complete your wedding photography package booking securely."
    >
      <Breadcrumb
        title="Checkout"
        items={[
          { label: 'Packages', href: '/package' },
          { label: 'Checkout', active: true },
        ]}
      />

      <div className="checkout_sec section_gap py-5 bg-light">
        <div className="container">
          <form onSubmit={handleSubmit}>
            <div className="row g-4">
              {/* Billing Details */}
              <div className="col-lg-7">
                <div className="card shadow-sm border rounded-3 bg-white">
                  <div className="card-body p-4 p-md-5">
                    <h4 className="fw-bold mb-4 text-dark border-bottom pb-3 fs-5">
                      Billing Details
                    </h4>

                    {errorMsg && (
                      <div className="alert alert-danger d-flex align-items-center mb-4">
                        <i className="fas fa-exclamation-triangle me-2" />
                        <span>{errorMsg}</span>
                      </div>
                    )}

                    <div className="row g-3">
                      <div className="col-md-6">
                        <label className="form-label small fw-semibold text-muted">
                          Full Name <span className="text-danger">*</span>
                        </label>
                        <input
                          type="text"
                          className="form-control"
                          placeholder="Your full name"
                          value={formData.name}
                          onChange={(e) =>
                            setFormData({ ...formData, name: e.target.value })
                          }
                          required
                        />
                      </div>

                      <div className="col-md-6">
                        <label className="form-label small fw-semibold text-muted">
                          Email Address <span className="text-danger">*</span>
                        </label>
                        <input
                          type="email"
                          className="form-control"
                          placeholder="Your email address"
                          value={formData.email}
                          onChange={(e) =>
                            setFormData({ ...formData, email: e.target.value })
                          }
                          required
                        />
                      </div>

                      <div className="col-md-6">
                        <label className="form-label small fw-semibold text-muted">
                          Phone Number <span className="text-danger">*</span>
                        </label>
                        <input
                          type="tel"
                          className="form-control"
                          placeholder="Your phone number"
                          value={formData.phone}
                          onChange={(e) =>
                            setFormData({ ...formData, phone: e.target.value })
                          }
                          required
                        />
                      </div>

                      <div className="col-md-6">
                        <label className="form-label small fw-semibold text-muted">
                          Country <span className="text-danger">*</span>
                        </label>
                        <select
                          className="form-select"
                          value={formData.country}
                          onChange={(e) =>
                            setFormData({ ...formData, country: e.target.value })
                          }
                          required
                        >
                          <option value="Bangladesh">Bangladesh</option>
                          <option value="India">India</option>
                        </select>
                      </div>

                      <div className="col-12">
                        <label className="form-label small fw-semibold text-muted">
                          Full Address <span className="text-danger">*</span>
                        </label>
                        <textarea
                          className="form-control"
                          rows={2}
                          placeholder="Street address, apartment, suite, etc."
                          value={formData.address}
                          onChange={(e) =>
                            setFormData({ ...formData, address: e.target.value })
                          }
                          required
                        />
                      </div>

                      <div className="col-md-4">
                        <label className="form-label small fw-semibold text-muted">
                          City <span className="text-danger">*</span>
                        </label>
                        <input
                          type="text"
                          className="form-control"
                          placeholder="City"
                          value={formData.city}
                          onChange={(e) =>
                            setFormData({ ...formData, city: e.target.value })
                          }
                          required
                        />
                      </div>

                      <div className="col-md-4">
                        <label className="form-label small fw-semibold text-muted">
                          State / District
                        </label>
                        <input
                          type="text"
                          className="form-control"
                          placeholder="State or District"
                          value={formData.state}
                          onChange={(e) =>
                            setFormData({ ...formData, state: e.target.value })
                          }
                        />
                      </div>

                      <div className="col-md-4">
                        <label className="form-label small fw-semibold text-muted">
                          Postcode
                        </label>
                        <input
                          type="text"
                          className="form-control"
                          placeholder="Postal Code"
                          value={formData.postcode}
                          onChange={(e) =>
                            setFormData({ ...formData, postcode: e.target.value })
                          }
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {/* Order Summary */}
              <div className="col-lg-5">
                <div className="card shadow-sm border rounded-3 bg-white mb-4">
                  <div className="card-body p-4 p-md-5">
                    <h4 className="fw-bold mb-4 text-dark border-bottom pb-3 fs-5">
                      Order Summary
                    </h4>

                    <div className="d-flex align-items-center mb-3 pb-3 border-bottom">
                      <div>
                        <h5 className="mb-1 fw-bold text-dark fs-6">
                          {packageItem.package_name}
                        </h5>
                        {packageItem.team && (
                          <p className="mb-0 text-muted small">
                            <i className="fas fa-users text-primary me-1" />
                            {packageItem.team}
                          </p>
                        )}
                      </div>
                    </div>

                    <div className="d-flex justify-content-between mb-2">
                      <span className="text-muted small">Package Price</span>
                      <span className="fw-semibold text-dark">
                        TK. {Number(packageItem.price).toLocaleString()}
                      </span>
                    </div>

                    <hr />

                    <div className="d-flex justify-content-between mb-4 align-items-center">
                      <strong className="fs-5">Total</strong>
                      <strong className="text-primary fs-4">
                        TK. {Number(packageItem.price).toLocaleString()}
                      </strong>
                    </div>

                    <div>
                      <button
                        type="submit"
                        disabled={loading}
                        className="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 py-3 fw-bold shadow-sm"
                      >
                        {loading ? (
                          <>
                            <span className="spinner-border spinner-border-sm" />
                            <span>Connecting to SSLCommerz...</span>
                          </>
                        ) : (
                          <>
                            <img
                              src="/frontend/assets/img/sslcommerz.png"
                              alt="SSLCommerz"
                              style={{ height: '22px', width: 'auto' }}
                              onError={(e) => {
                                e.target.style.display = 'none';
                              }}
                            />
                            <span>Pay Now - TK. {Number(packageItem.price).toLocaleString()}</span>
                          </>
                        )}
                      </button>

                      <div className="text-center mt-3 mb-4">
                        <small className="text-muted">
                          <i className="fas fa-lock me-1 text-success" />
                          Secured 256-bit SSL Payment Gateway
                        </small>
                      </div>

                      {cleanPhone && (
                        <a
                          href={`https://wa.me/${cleanPhone}`}
                          className="btn btn-outline-dark w-100 py-2 d-flex align-items-center justify-content-center gap-2"
                          target="_blank"
                          rel="noopener noreferrer"
                        >
                          <i className="fab fa-whatsapp text-success fs-5" />
                          <span>Contact with us on WhatsApp</span>
                        </a>
                      )}
                    </div>
                  </div>
                </div>

                {/* Package Features List */}
                {packageItem.features && packageItem.features.length > 0 && (
                  <div className="card shadow-sm border rounded-3 bg-white">
                    <div className="card-body p-4">
                      <h6 className="fw-bold mb-3 text-dark fs-6">Package Features:</h6>
                      <ul className="list-unstyled mb-0 small">
                        {packageItem.features.map((feature, idx) => (
                          <li key={feature.id || idx} className="mb-2 d-flex align-items-start">
                            <i className="fas fa-check-circle text-success me-2 mt-1" />
                            <span className="text-muted">{feature.name}</span>
                          </li>
                        ))}
                      </ul>
                    </div>
                  </div>
                )}
              </div>
            </div>
          </form>
        </div>
      </div>
    </AppLayout>
  );
}
