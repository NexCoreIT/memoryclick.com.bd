"use client";

import React, { useState } from "react";
import Lightbox from "yet-another-react-lightbox";
import { resolveImageUrl } from "@/lib/api";

interface ShootGalleryGridProps {
  images: Array<{ path: string; url: string }>;
  title?: string;
}

export default function ShootGalleryGrid({ images, title }: ShootGalleryGridProps) {
  const [open, setOpen] = useState(false);
  const [index, setIndex] = useState(0);

  if (!images || images.length === 0) {
    return (
      <div className="text-center py-4">
        <p className="text-muted fw-semibold">No additional gallery photos found for this shoot.</p>
      </div>
    );
  }

  const slides = images.map((img) => ({
    src: resolveImageUrl(img.url || img.path),
    alt: title || "Gallery Image",
  }));

  const openLightboxAt = (idx: number) => {
    setIndex(idx);
    setOpen(true);
  };

  return (
    <>
      <div className="row gy-4">
        {images.map((img, idx) => (
          <div key={idx} className="col-lg-4 col-md-6 col-sm-6">
            <div
              className="position-relative overflow-hidden rounded shadow-sm mb-2"
              style={{ height: "280px", cursor: "pointer" }}
              onClick={() => openLightboxAt(idx)}
            >
              <img
                src={resolveImageUrl(img.url || img.path)}
                className="w-100 h-100 rounded"
                alt={`Photo ${idx + 1}`}
                style={{ objectFit: "cover", transition: "transform 0.4s ease" }}
              />
              <div
                className="position-absolute top-0 end-0 p-2 m-2 bg-dark bg-opacity-50 text-white rounded-circle d-flex align-items-center justify-content-center"
                style={{ width: "32px", height: "32px" }}
              >
                <i className="fas fa-search-plus small" />
              </div>
            </div>
          </div>
        ))}
      </div>

      {open && (
        <Lightbox
          open={open}
          close={() => setOpen(false)}
          index={index}
          slides={slides}
        />
      )}
    </>
  );
}
