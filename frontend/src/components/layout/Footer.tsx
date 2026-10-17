import React from "react";
import Link from "next/link";
import { SiteSettings } from "@/lib/api";

interface FooterProps {
  settings?: SiteSettings | null;
}

export default function Footer({ settings }: FooterProps) {
  const currentYear = new Date().getFullYear();
  const footerTitle = settings?.footer_title || "MemoryClick.com.bd";

  return (
    <div className="footer_sec bg-dark text-white border-top border-secondary py-4">
      <div className="container">
        <div className="d-md-flex justify-content-center text-center justify-content-between align-items-center">
          {/* Copyright */}
          <p className="mb-0">
            &copy; {currentYear}{" "}
            <Link href="/" className="text-primary text-decoration-none">
              {footerTitle}
            </Link>
            . All Rights Reserved.
          </p>

          {/* Social Media Links */}
          <div className="d-flex my-4 my-md-0 justify-content-center align-items-center">
            <a
              className="btn btn-square btn-outline-primary rounded-circle me-2"
              href={settings?.facebook_link || "#"}
              target="_blank"
              rel="noopener noreferrer"
              aria-label="Facebook"
            >
              <i className="fab fa-facebook-f" />
            </a>

            <a
              className="btn btn-square btn-outline-primary rounded-circle me-2"
              href={settings?.youtube_link || "#"}
              target="_blank"
              rel="noopener noreferrer"
              aria-label="YouTube"
            >
              <i className="fab fa-youtube" />
            </a>

            <a
              className="btn btn-square btn-outline-primary rounded-circle me-2"
              href={settings?.instagram_link || "#"}
              target="_blank"
              rel="noopener noreferrer"
              aria-label="Instagram"
            >
              <i className="fab fa-instagram" />
            </a>
          </div>

          {/* Developer Credit */}
          <p className="mb-0">
            Developed by{" "}
            <a
              className="text-primary text-decoration-none"
              href="https://fastitcare.com.bd/"
              target="_blank"
              rel="noopener noreferrer"
            >
              Fast IT Care
            </a>
          </p>
        </div>
      </div>
    </div>
  );
}
