import React from 'react';
import { Link } from '@inertiajs/react';

export default function Breadcrumb({ title, items }) {
  return (
    <div className="breadcrumb_sec bg-light py-4 mb-4">
      <div className="container">
        <h4 className="fw-bold text-dark mb-1">{title}</h4>
        <nav aria-label="breadcrumb">
          <ol className="breadcrumb mb-0">
            <li className="breadcrumb-item">
              <Link href="/" className="text-decoration-none text-muted">
                Home
              </Link>
            </li>
            {items ? (
              items.map((item, idx) => (
                <li
                  key={idx}
                  className={`breadcrumb-item ${item.active ? 'active fw-semibold text-primary' : ''}`}
                  aria-current={item.active ? 'page' : undefined}
                >
                  {item.href && !item.active ? (
                    <Link href={item.href} className="text-decoration-none text-muted">
                      {item.label}
                    </Link>
                  ) : (
                    item.label
                  )}
                </li>
              ))
            ) : (
              <li className="breadcrumb-item active text-primary fw-semibold" aria-current="page">
                {title}
              </li>
            )}
          </ol>
        </nav>
      </div>
    </div>
  );
}
