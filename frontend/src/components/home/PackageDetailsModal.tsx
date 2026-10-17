"use client";

import React from "react";
import Link from "next/link";
import { PackageItem } from "@/lib/api";

interface PackageDetailsModalProps {
  packageItem: PackageItem | null;
  onClose: () => void;
  whatsappPhone?: string;
}

export default function PackageDetailsModal({
  packageItem,
  onClose,
  whatsappPhone,
}: PackageDetailsModalProps) {
  if (!packageItem) return null;

  const phone = whatsappPhone || packageItem.whatsapp_phone || "";
  const cleanPhone = phone.replace(/[^0-9]/g, "");

  return (
    <div className="modal-backdrop-custom" onClick={onClose}>
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
            <ul className="list-unstyled text-start mx-auto my-4 bg-light p-3 rounded" style={{ maxWidth: "500px" }}>
              {packageItem.features.map((feature, idx) => (
                <li key={feature.id || idx} className="mb-2 d-flex align-items-start">
                  <i className="fas fa-check-circle text-success me-2 mt-1" />
                  <span>{feature.name}</span>
                </li>
              ))}
            </ul>
          )}

          <div className="alert alert-warning text-start mx-auto p-3 small mb-4" style={{ maxWidth: "550px" }}>
            <h6 className="fw-bold mb-1">For outside of Dhaka & Chittagong metropolitan area:</h6>
            <p className="mb-0 text-muted">
              Transportation + Accommodation & 15% shift charge (Package Price) will be added with package price.
            </p>
          </div>

          {packageItem.description && (
            <div
              className="package-description text-start mt-3"
              dangerouslySetInnerHTML={{ __html: packageItem.description }}
            />
          )}
        </div>

        <div className="d-flex flex-wrap border-top pt-3 mt-3 align-items-center justify-content-between gap-3">
          <div>
            <h4 className="mb-0 fw-bold text-dark">
              TK. {Number(packageItem.price).toLocaleString()}
            </h4>
          </div>
          <div className="d-flex gap-2 align-items-center">
            {cleanPhone && (
              <a
                href={`https://wa.me/${cleanPhone}`}
                className="btn btn-sm btn-dark px-3 py-2"
                target="_blank"
                rel="noopener noreferrer"
              >
                <i className="fab fa-whatsapp me-1" /> Contact with us
              </a>
            )}

            {packageItem.ssl_status !== 0 && (
              <Link
                href={`/checkout?package_id=${packageItem.id}`}
                className="btn btn-sm btn-success d-flex align-items-center gap-2 px-3 py-2 text-white"
                onClick={onClose}
              >
                <img
                  src="/frontend/assets/img/sslcommerz.png"
                  alt="SSLCommerz"
                  style={{ height: "20px", width: "auto" }}
                  onError={(e) => {
                    // Fallback if image path differs
                    (e.target as HTMLElement).style.display = "none";
                  }}
                />
                <span>Checkout</span>
              </Link>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
