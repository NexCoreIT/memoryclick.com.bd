import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function HomeContactSection({ contact }) {
  const { props } = usePage();
  const flash = props.flash;

  const { data, setData, post, processing, reset, errors, recentlySuccessful } = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/contact-store', {
      preserveScroll: true,
      onSuccess: () => reset(),
    });
  };

  let mapSrc = contact?.google_map || '';
  if (mapSrc.includes('src="') || mapSrc.includes("src='")) {
    const match = mapSrc.match(/src=["']([^"']+)["']/);
    if (match && match[1]) {
      mapSrc = match[1];
    }
  }

  return (
    <div className="contact_sec py-5 mt-4 mt-lg-5 bg-light">
      <div className="container">
        <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
          <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
            Contact Us
          </p>
          <h2 className="display-6 mb-3 fw-bold text-dark">Get In Touch</h2>
          <p className="text-muted small">
            We'd love to hear from you. Leave us a message!
          </p>
        </div>

        <div className="row g-4">
          {/* Contact Details & Map */}
          <div className="col-lg-5 order-lg-2">
            <div className="contact_info bg-white p-4 rounded shadow-sm h-100 d-flex flex-column">
              {contact?.address && (
                <div className="d-flex mb-4 align-items-center">
                  <div className="me-3 text-primary fs-4">
                    <i className="fas fa-map-marker-alt" />
                  </div>
                  <div className="text-muted">{contact.address}</div>
                </div>
              )}

              {contact?.email && (
                <div className="d-flex mb-4 align-items-center">
                  <div className="me-3 text-primary fs-4">
                    <i className="far fa-envelope" />
                  </div>
                  <div>
                    <a
                      href={`mailto:${contact.email}`}
                      className="text-decoration-none text-muted"
                    >
                      {contact.email}
                    </a>
                  </div>
                </div>
              )}

              {contact?.phone && (
                <div className="d-flex align-items-center mb-4">
                  <div className="me-3 text-primary fs-4">
                    <i className="fas fa-phone-alt" />
                  </div>
                  <div>
                    <a
                      href={`tel:${contact.phone}`}
                      className="text-decoration-none text-muted"
                    >
                      {contact.phone}
                    </a>
                  </div>
                </div>
              )}

              {mapSrc && (
                <div className="mt-auto overflow-hidden rounded shadow-sm" style={{ height: '220px' }}>
                  <iframe
                    src={mapSrc}
                    width="100%"
                    height="100%"
                    style={{ border: 0 }}
                    allowFullScreen=""
                    loading="lazy"
                    title="Location Map"
                  />
                </div>
              )}
            </div>
          </div>

          {/* Contact Form */}
          <div className="col-lg-7 order-lg-1">
            <div className="bg-white p-4 p-md-5 rounded shadow-sm h-100">
              <h4 className="fw-bold text-dark mb-4">Send a Message</h4>

              {(flash?.success || recentlySuccessful) && (
                <div className="alert alert-success alert-dismissible fade show" role="alert">
                  <i className="fas fa-check-circle me-2" />
                  {flash?.success || 'Your message has been sent successfully!'}
                </div>
              )}

              {flash?.error && (
                <div className="alert alert-danger" role="alert">
                  <i className="fas fa-exclamation-triangle me-2" />
                  {flash.error}
                </div>
              )}

              <form onSubmit={handleSubmit}>
                <div className="row g-3">
                  <div className="col-md-6">
                    <div className="form-group mb-3">
                      <label className="form-label text-muted small fw-semibold">
                        Your Name <span className="text-danger">*</span>
                      </label>
                      <input
                        type="text"
                        className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                        placeholder="John Doe"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                      />
                      {errors.name && <div className="invalid-feedback">{errors.name}</div>}
                    </div>
                  </div>

                  <div className="col-md-6">
                    <div className="form-group mb-3">
                      <label className="form-label text-muted small fw-semibold">
                        Your Email <span className="text-danger">*</span>
                      </label>
                      <input
                        type="email"
                        className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                        placeholder="john@example.com"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        required
                      />
                      {errors.email && <div className="invalid-feedback">{errors.email}</div>}
                    </div>
                  </div>

                  <div className="col-12">
                    <div className="form-group mb-3">
                      <label className="form-label text-muted small fw-semibold">
                        Subject <span className="text-danger">*</span>
                      </label>
                      <input
                        type="text"
                        className={`form-control ${errors.subject ? 'is-invalid' : ''}`}
                        placeholder="Wedding Photography Inquiry"
                        value={data.subject}
                        onChange={(e) => setData('subject', e.target.value)}
                        required
                      />
                      {errors.subject && <div className="invalid-feedback">{errors.subject}</div>}
                    </div>
                  </div>

                  <div className="col-12">
                    <div className="form-group mb-3">
                      <label className="form-label text-muted small fw-semibold">
                        Message <span className="text-danger">*</span>
                      </label>
                      <textarea
                        rows="5"
                        className={`form-control ${errors.message ? 'is-invalid' : ''}`}
                        placeholder="Tell us about your event date, venue, and requirements..."
                        value={data.message}
                        onChange={(e) => setData('message', e.target.value)}
                        required
                      />
                      {errors.message && <div className="invalid-feedback">{errors.message}</div>}
                    </div>
                  </div>

                  <div className="col-12 mt-2">
                    <button
                      type="submit"
                      disabled={processing}
                      className="btn btn-primary py-3 px-5 rounded-pill shadow-sm fw-bold"
                    >
                      {processing ? (
                        <>
                          <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" />
                          Sending...
                        </>
                      ) : (
                        'Send Message'
                      )}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
