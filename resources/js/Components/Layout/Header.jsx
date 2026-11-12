import React, { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { resolveImageUrl } from '@/Utils/image';

export default function Header() {
  const { url, props } = usePage();
  const settings = props.settings;

  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [portfolioOpen, setPortfolioOpen] = useState(false);
  const [mobilePortfolioOpen, setMobilePortfolioOpen] = useState(false);

  // Close menus on page navigation
  useEffect(() => {
    setMobileMenuOpen(false);
    setPortfolioOpen(false);
  }, [url]);

  // Lock body scroll when mobile drawer is open
  useEffect(() => {
    if (mobileMenuOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
    return () => {
      document.body.style.overflow = '';
    };
  }, [mobileMenuOpen]);

  const logoSrc = settings?.logo_url ? resolveImageUrl(settings.logo_url) : '/fav.png';

  const isHome = url === '/' || url === '';
  const isAbout = url.startsWith('/about');
  const isPhotography = url.startsWith('/photography');
  const isCinematography = url.startsWith('/cinematography');
  const isPortfolio = isPhotography || isCinematography;
  const isPackage = url.startsWith('/package') || url.startsWith('/division');
  const isBlog = url.startsWith('/blog');
  const isContact = url.startsWith('/contact-us');
  const isTerm = url.startsWith('/term-and-condition');

  return (
    <>
      {/* Navbar Start */}
      <nav className="navbar navbar-expand-lg bg-white border-bottom navbar-light sticky-top px-4 px-lg-5">
        <div className="container d-flex align-items-center justify-content-between">
          <Link href="/" className="navbar-brand py-0 d-flex align-items-center">
            <img
              src={logoSrc}
              alt="MemoryClick Logo"
              style={{ height: '45px', width: 'auto', objectFit: 'contain' }}
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
                className={`nav-item nav-link ${isHome ? 'active' : ''}`}
              >
                Home
              </Link>

              <Link
                href="/about"
                className={`nav-item nav-link ${isAbout ? 'active' : ''}`}
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
                  className={`nav-link dropdown-toggle ${isPortfolio ? 'active' : ''}`}
                  role="button"
                  aria-expanded={portfolioOpen}
                >
                  Portfolio
                </a>
                <div
                  className={`dropdown-menu m-0 shadow-sm border-0 ${portfolioOpen ? 'show' : ''}`}
                >
                  <Link
                    href="/photography"
                    className={`dropdown-item ${isPhotography ? 'active' : ''}`}
                  >
                    Photography
                  </Link>
                  <Link
                    href="/cinematography"
                    className={`dropdown-item ${isCinematography ? 'active' : ''}`}
                  >
                    Cinematography
                  </Link>
                </div>
              </div>

              <Link
                href="/package"
                className={`nav-item nav-link ${isPackage ? 'active' : ''}`}
              >
                Packages
              </Link>

              <Link
                href="/blog"
                className={`nav-item nav-link ${isBlog ? 'active' : ''}`}
              >
                Blog
              </Link>

              <Link
                href="/contact-us"
                className={`nav-item nav-link ${isContact ? 'active' : ''}`}
              >
                Contact Us
              </Link>

              <Link
                href="/term-and-condition"
                className={`nav-item nav-link ${isTerm ? 'active' : ''}`}
              >
                Terms
              </Link>
            </div>

            {/* Book Now Button */}
            <div className="d-none d-lg-block ms-4">
              <Link href="/package" className="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                Book Now
              </Link>
            </div>
          </div>
        </div>
      </nav>

      {/* Mobile Drawer Overlay */}
      {mobileMenuOpen && (
        <div
          className="mobile-drawer-overlay"
          onClick={() => setMobileMenuOpen(false)}
        />
      )}

      {/* Mobile Drawer Menu */}
      <div className={`mobile-drawer ${mobileMenuOpen ? 'open' : ''}`}>
        <div className="p-3 border-bottom d-flex align-items-center justify-content-between bg-light">
          <Link href="/" onClick={() => setMobileMenuOpen(false)}>
            <img
              src={logoSrc}
              alt="MemoryClick Logo"
              style={{ height: '36px', width: 'auto', objectFit: 'contain' }}
            />
          </Link>
          <button
            type="button"
            className="btn-close shadow-none"
            onClick={() => setMobileMenuOpen(false)}
            aria-label="Close menu"
          />
        </div>

        <div className="d-flex flex-column py-2">
          <Link
            href="/"
            onClick={() => setMobileMenuOpen(false)}
            className={`nav-link ${isHome ? 'active text-primary fw-bold' : ''}`}
          >
            Home
          </Link>

          <Link
            href="/about"
            onClick={() => setMobileMenuOpen(false)}
            className={`nav-link ${isAbout ? 'active text-primary fw-bold' : ''}`}
          >
            About Us
          </Link>

          <div>
            <div
              className={`nav-link d-flex align-items-center justify-content-between ${isPortfolio ? 'active text-primary fw-bold' : ''}`}
              onClick={() => setMobilePortfolioOpen(!mobilePortfolioOpen)}
              style={{ cursor: 'pointer' }}
            >
              <span>Portfolio</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                style={{
                  transform: mobilePortfolioOpen ? 'rotate(180deg)' : 'rotate(0deg)',
                  transition: 'transform 0.2s ease',
                }}
              >
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </div>

            {mobilePortfolioOpen && (
              <div className="bg-light ps-3 border-bottom">
                <Link
                  href="/photography"
                  onClick={() => setMobileMenuOpen(false)}
                  className={`nav-link py-2 ps-3 border-0 ${isPhotography ? 'active text-primary fw-bold' : ''}`}
                  style={{ fontSize: '14px' }}
                >
                  <i className="fas fa-camera me-2 text-primary"></i> Photography
                </Link>
                <Link
                  href="/cinematography"
                  onClick={() => setMobileMenuOpen(false)}
                  className={`nav-link py-2 ps-3 border-0 ${isCinematography ? 'active text-primary fw-bold' : ''}`}
                  style={{ fontSize: '14px' }}
                >
                  <i className="fas fa-video me-2 text-primary"></i> Cinematography
                </Link>
              </div>
            )}
          </div>

          <Link
            href="/package"
            onClick={() => setMobileMenuOpen(false)}
            className={`nav-link ${isPackage ? 'active text-primary fw-bold' : ''}`}
          >
            Packages
          </Link>

          <Link
            href="/blog"
            onClick={() => setMobileMenuOpen(false)}
            className={`nav-link ${isBlog ? 'active text-primary fw-bold' : ''}`}
          >
            Blog
          </Link>

          <Link
            href="/contact-us"
            onClick={() => setMobileMenuOpen(false)}
            className={`nav-link ${isContact ? 'active text-primary fw-bold' : ''}`}
          >
            Contact Us
          </Link>

          <Link
            href="/term-and-condition"
            onClick={() => setMobileMenuOpen(false)}
            className={`nav-link ${isTerm ? 'active text-primary fw-bold' : ''}`}
          >
            Terms & Conditions
          </Link>

          <div className="p-3 mt-3">
            <Link
              href="/package"
              onClick={() => setMobileMenuOpen(false)}
              className="btn btn-primary rounded-pill w-100 py-2 fw-bold shadow-sm"
            >
              Book Now
            </Link>
          </div>
        </div>
      </div>
    </>
  );
}
