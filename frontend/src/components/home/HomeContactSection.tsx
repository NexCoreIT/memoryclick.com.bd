"use client";

import React, { useState } from "react";
import { submitContact } from "@/lib/api";

interface HomeContactSectionProps {
  contact: {
    phone: string;
    email: string;
    address: string;
    google_map?: string;
  };
}

export default function HomeContactSection({ contact }: HomeContactSectionProps) {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    subject: "",
    message: "",
  });
  const [loading, setLoading] = useState(false);
  const [successMsg, setSuccessMsg] = useState("");
  const [errorMsg, setErrorMsg] = useState("");

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setSuccessMsg("");
    setErrorMsg("");

    try {
      const res = await submitContact(formData);
      setSuccessMsg(res.message || "Your message has been sent successfully!");
      setFormData({ name: "", email: "", subject: "", message: "" });
    } catch (err: any) {
      setErrorMsg(err.message || "Failed to send message. Please try again.");
    } finally {
      setLoading(false);
    }
  };

  // Extract clean iframe src if user entered raw iframe HTML
  let mapSrc = contact.google_map || "";
  if (mapSrc.includes('src="') || mapSrc.includes("src='")) {
    const match = mapSrc.match(/src=["']([^"']+)["']/);
    if (match && match[1]) {
      mapSrc = match[1];
    }
  }

  return (
    <div className="contact_sec py-5 mt-4 mt-lg-5 bg-light">
      <div className="container">
        <div className="text-center mx-auto mb-5" style={{ maxWidth: "600px" }}>
          <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: "1px" }}>
            Contact Us
          </p>
          <h2 className="display-6 mb-3 fw-bold text-dark">Get In Touch</h2>
          <p className="text-muted small">
            We&apos;d love to hear from you. Leave us a message!
          </p>
        </div>

        <div className="row g-4">
          {/* Contact Details & Map */}
          <div className="col-lg-5 order-lg-2">
            <div className="contact_info bg-white p-4 rounded shadow-sm h-100 d-flex flex-column">
              {contact.address && (
                <div className="d-flex mb-4 align-items-center">
                  <div className="me-3 text-primary fs-4">
                    <i className="fas fa-map-marker-alt" />
                  </div>
                  <div className="text-muted">{contact.address}</div>
                </div>
              )}

              {contact.email && (
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

              {contact.phone && (
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
                <div className="map mt-auto pt-3 rounded overflow-hidden" style={{ minHeight: "260px" }}>
                  <iframe
                    src={mapSrc}
                    width="100%"
                    height="260"
                    className="border-0 rounded w-100"
                    allowFullScreen
                    loading="lazy"
                    referrerPolicy="no-referrer-when-downgrade"
                    title="Google Map Location"
                  />
                </div>
              )}
            </div>
          </div>

          {/* Form */}
          <div className="col-lg-7 order-lg-1">
            <div className="bg-white p-4 p-md-5 rounded shadow-sm h-100">
              <h4 className="mb-4 fw-bold text-dark">Send Us a Message</h4>

              {successMsg && (
                <div className="alert alert-success d-flex align-items-center mb-4">
                  <i className="fas fa-check-circle me-2" />
                  <span>{successMsg}</span>
                </div>
              )}

              {errorMsg && (
                <div className="alert alert-danger d-flex align-items-center mb-4">
                  <i className="fas fa-exclamation-triangle me-2" />
                  <span>{errorMsg}</span>
                </div>
              )}

              <form onSubmit={handleSubmit}>
                <div className="row g-3">
                  <div className="col-md-6">
                    <label className="form-label small fw-semibold text-muted">
                      Your Name <span className="text-danger">*</span>
                    </label>
                    <input
                      type="text"
                      className="form-control shadow-none py-2"
                      placeholder="Your Full Name"
                      value={formData.name}
                      onChange={(e) =>
                        setFormData({ ...formData, name: e.target.value })
                      }
                      required
                    />
                  </div>

                  <div className="col-md-6">
                    <label className="form-label small fw-semibold text-muted">
                      Your Email <span className="text-danger">*</span>
                    </label>
                    <input
                      type="email"
                      className="form-control shadow-none py-2"
                      placeholder="Your Email Address"
                      value={formData.email}
                      onChange={(e) =>
                        setFormData({ ...formData, email: e.target.value })
                      }
                      required
                    />
                  </div>

                  <div className="col-12">
                    <label className="form-label small fw-semibold text-muted">
                      Subject / Phone <span className="text-danger">*</span>
                    </label>
                    <input
                      type="text"
                      className="form-control shadow-none py-2"
                      placeholder="Subject or Contact Number"
                      value={formData.subject}
                      onChange={(e) =>
                        setFormData({ ...formData, subject: e.target.value })
                      }
                      required
                    />
                  </div>

                  <div className="col-12">
                    <label className="form-label small fw-semibold text-muted">
                      Message <span className="text-danger">*</span>
                    </label>
                    <textarea
                      className="form-control shadow-none py-2"
                      placeholder="How can we help make your event unforgettable?"
                      rows={5}
                      value={formData.message}
                      onChange={(e) =>
                        setFormData({ ...formData, message: e.target.value })
                      }
                      required
                    />
                  </div>

                  <div className="col-12 text-center mt-4">
                    <button
                      className="btn btn-primary py-3 px-5 w-100 fw-bold shadow-sm"
                      type="submit"
                      disabled={loading}
                    >
                      {loading ? (
                        <>
                          <span className="spinner-border spinner-border-sm me-2" />
                          Sending Message...
                        </>
                      ) : (
                        "Send Message"
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
