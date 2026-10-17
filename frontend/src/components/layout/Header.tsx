"use client";

import React, { useState } from "react";
import Link from "next/link";
import Image from "next/image";
import { usePathname } from "next/navigation";
import { resolveImageUrl, SiteSettings } from "@/lib/api";

interface HeaderProps {
  settings?: SiteSettings | null;
}

export default function Header({ settings }: HeaderProps) {
  const pathname = usePathname();
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [portfolioOpen, setPortfolioOpen] = useState(false);
  const [mobilePortfolioOpen, setMobilePortfolioOpen] = useState(false);

  const logoSrc = settings?.logo_url ? resolveImageUrl(settings.logo_url) : "/fav.png";

  const isHome = pathname === "/";
  const isAbout = pathname === "/about";
  const isPhotography = pathname.startsWith("/photography");
  const isCinematography = pathname.startsWith("/cinematography");
  const isPortfolio = isPhotography || isCinematography;
  const isPackage = pathname.startsWith("/package") || pathname.startsWith("/division");
  const isBlog = pathname.startsWith("/blog");
  const isContact = pathname === "/contact-us";
  const isTerm = pathname === "/term-and-condition";

  return (
    <>
      {/* Navbar Start */}
      <nav className="navbar navbar-expand-lg bg-white border-bottom navbar-light sticky-top px-4 px-lg-5">
        <div className="container d-flex align-items-center justify-content-between">
          <Link href="/" className="navbar-brand py-0">
            <Image
              src={logoSrc}
              alt="MemoryClick Logo"
              width={160}
              height={45}
              style={{ height: "45px", width: "auto", objectFit: "contain" }}
              priority
            />
          </Link>

          {/* Mobile Menu Toggle Button */}
          <button
            type="button"
            className="navbar-toggler shadow-none p-2 border-0 d-lg-none"
            onClick={() => setMobileMenuOpen(true)}
            aria-label="Toggle navigation"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="26"
              height="26"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              strokeWidth="2"
              strokeLinecap="round"
              strokeLinejoin="round"
            >
              <line x1="21" y1="12" x2="9" y2="12"></line>
              <line x1="21" y1="18" x2="7" y2="18"></line>
              <line x1="21" y1="6" x2="3" y2="6"></line>
            </svg>
          </button>

          {/* Desktop Navigation */}
          <div className="collapse navbar-collapse justify-content-between py-4 py-lg-0 d-none d-lg-flex" id="navbarCollapse">
            <div className="navbar-nav ms-auto py-0 align-items-center">
              <Link
                href="/"
                className={`nav-item nav-link ${isHome ? "active" : ""}`}
              >
                Home
              </Link>

              <Link
                href="/about"
                className={`nav-item nav-link ${isAbout ? "active" : ""}`}
              >
                About Us
              </Link>

              {/* Portfolio Dropdown */}
              <div
                className="nav-item dropdown position-relative"
                onMouseEnter={() => setPortfolioOpen(true)}
                onMouseLeave={() => setPortfolioOpen(false)}
              >
                <a
                  href="#"
                  onClick={(e) => {
                    e.preventDefault();
                    setPortfolioOpen(!portfolioOpen);
                  }}
                  className={`nav-link dropdown-toggle ${isPortfolio ? "active" : ""}`}
                >
                  Portfolio
                </a>
                <div
                  className={`dropdown-menu rounded-0 shadow-sm border-0 m-0 py-2 dropdown-menu-end ${
                    portfolioOpen ? "show" : ""
                  }`}
                  style={{
                    display: portfolioOpen ? "block" : "none",
                    position: "absolute",
                    top: "100%",
                    right: 0,
                    zIndex: 1000,
                    minWidth: "160px",
                    backgroundColor: "#fff",
                  }}
                >
                  <Link
                    href="/photography"
                    className={`dropdown-item py-2 ${isPhotography ? "active text-primary fw-bold" : ""}`}
                    onClick={() => setPortfolioOpen(false)}
                  >
                    Photography
                  </Link>
                  <Link
                    href="/cinematography"
                    className={`dropdown-item py-2 ${isCinematography ? "active text-primary fw-bold" : ""}`}
                    onClick={() => setPortfolioOpen(false)}
                  >
                    Cinematography
                  </Link>
                </div>
              </div>

              <Link
                href="/package"
                className={`nav-item nav-link ${isPackage ? "active" : ""}`}
              >
                Package
              </Link>

              <Link
                href="/blog"
                className={`nav-item nav-link ${isBlog ? "active" : ""}`}
              >
                Blog
              </Link>

              <Link
                href="/contact-us"
                className={`nav-item nav-link ${isContact ? "active" : ""}`}
              >
                Contact Us
              </Link>

              <Link
                href="/term-and-condition"
                className={`nav-item nav-link ${isTerm ? "active" : ""}`}
              >
                Term
              </Link>
            </div>
          </div>
        </div>
      </nav>
      {/* Navbar End */}

      {/* Mobile Offcanvas Drawer */}
      {mobileMenuOpen && (
        <div
          className="mobile-drawer-overlay"
          onClick={() => setMobileMenuOpen(false)}
        />
      )}

      <div className={`mobile-drawer ${mobileMenuOpen ? "open" : ""}`}>
        <div className="d-flex align-items-center justify-content-between p-3 border-bottom">
          <Link href="/" onClick={() => setMobileMenuOpen(false)}>
            <Image
              src={logoSrc}
              alt="MemoryClick Logo"
              width={140}
              height={40}
              style={{ height: "35px", width: "auto", objectFit: "contain" }}
            />
          </Link>
          <button
            type="button"
            className="btn-close shadow-none"
            aria-label="Close"
            onClick={() => setMobileMenuOpen(false)}
          />
        </div>

        <div className="p-3">
          <Link
            href="/"
            className={`d-block py-2 text-decoration-none fw-semibold border-bottom ${
              isHome ? "text-primary" : "text-dark"
            }`}
            onClick={() => setMobileMenuOpen(false)}
          >
            Home
          </Link>

          <Link
            href="/about"
            className={`d-block py-2 text-decoration-none fw-semibold border-bottom ${
              isAbout ? "text-primary" : "text-dark"
            }`}
            onClick={() => setMobileMenuOpen(false)}
          >
            About Us
          </Link>

          {/* Portfolio Collapsible */}
          <div className="border-bottom py-2">
            <button
              className="d-flex justify-content-between align-items-center w-100 bg-transparent border-0 p-0 text-start fw-semibold text-dark"
              onClick={() => setMobilePortfolioOpen(!mobilePortfolioOpen)}
            >
              <span>Portfolio</span>
              <i
                className={`fas fa-chevron-${mobilePortfolioOpen ? "up" : "down"} text-muted small`}
              />
            </button>
            {mobilePortfolioOpen && (
              <div className="ps-3 pt-2">
                <Link
                  href="/photography"
                  className={`d-block py-2 text-decoration-none small ${
                    isPhotography ? "text-primary fw-bold" : "text-secondary"
                  }`}
                  onClick={() => setMobileMenuOpen(false)}
                >
                  Photography
                </Link>
                <Link
                  href="/cinematography"
                  className={`d-block py-2 text-decoration-none small ${
                    isCinematography ? "text-primary fw-bold" : "text-secondary"
                  }`}
                  onClick={() => setMobileMenuOpen(false)}
                >
                  Cinematography
                </Link>
              </div>
            )}
          </div>

          <Link
            href="/package"
            className={`d-block py-2 text-decoration-none fw-semibold border-bottom ${
              isPackage ? "text-primary" : "text-dark"
            }`}
            onClick={() => setMobileMenuOpen(false)}
          >
            Package
          </Link>

          <Link
            href="/blog"
            className={`d-block py-2 text-decoration-none fw-semibold border-bottom ${
              isBlog ? "text-primary" : "text-dark"
            }`}
            onClick={() => setMobileMenuOpen(false)}
          >
            Blog
          </Link>

          <Link
            href="/contact-us"
            className={`d-block py-2 text-decoration-none fw-semibold border-bottom ${
              isContact ? "text-primary" : "text-dark"
            }`}
            onClick={() => setMobileMenuOpen(false)}
          >
            Contact Us
          </Link>

          <Link
            href="/term-and-condition"
            className={`d-block py-2 text-decoration-none fw-semibold ${
              isTerm ? "text-primary" : "text-dark"
            }`}
            onClick={() => setMobileMenuOpen(false)}
          >
            Term
          </Link>
        </div>
      </div>
    </>
  );
}
