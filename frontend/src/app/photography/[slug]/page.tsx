import React from "react";
import type { Metadata } from "next";
import { notFound } from "next/navigation";
import Breadcrumb from "@/components/ui/Breadcrumb";
import ShootGalleryGrid from "@/components/photography/ShootGalleryGrid";
import { getPhotographyDetails, resolveImageUrl } from "@/lib/api";

interface PhotographyDetailsPageProps {
  params: Promise<{ slug: string }>;
}

export async function generateMetadata({
  params,
}: PhotographyDetailsPageProps): Promise<Metadata> {
  const { slug } = await params;
  try {
    const data = await getPhotographyDetails(slug);
    return {
      title: `${data.title} | Memory Click`,
      description: `Photography session: ${data.title} for ${data.client_name || "Client"}`,
      openGraph: {
        images: [{ url: resolveImageUrl(data.image_url || data.image) }],
      },
    };
  } catch (error) {
    return {
      title: "Photography Details | Memory Click",
    };
  }
}

export default async function PhotographyDetailsPage({
  params,
}: PhotographyDetailsPageProps) {
  const { slug } = await params;
  let data;

  try {
    data = await getPhotographyDetails(slug);
  } catch (error) {
    notFound();
  }

  return (
    <>
      <Breadcrumb
        title={data.title}
        items={[
          { label: "Photography", href: "/photography" },
          { label: data.title, active: true },
        ]}
      />

      {/* Hero Section */}
      <div className="hero-header pb-4">
        <div className="container py-4">
          <div className="row justify-content-center">
            <div className="col-lg-10 text-center">
              <div className="mb-4 overflow-hidden rounded shadow-sm" style={{ maxHeight: "550px" }}>
                <img
                  src={resolveImageUrl(data.image_url || data.image)}
                  className="img-fluid rounded w-100"
                  alt={data.title}
                  style={{ objectFit: "cover" }}
                />
              </div>

              <h1 className="display-5 my-4 fw-bold text-dark">{data.title}</h1>
              {data.client_name && (
                <p className="text-primary fw-bold mb-1 fs-5">{data.client_name}</p>
              )}
              {data.category?.name && (
                <p className="mb-1 text-muted">{data.category.name}</p>
              )}
              {data.package_name && (
                <p className="mb-0 text-muted small">Package: <span className="fw-semibold text-dark">{data.package_name}</span></p>
              )}
            </div>
          </div>
        </div>
      </div>

      {/* Gallery Section */}
      <div className="cinematography_sec section_gap py-5 bg-light">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: "600px" }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: "1px" }}>
              Gallery
            </p>
            <h3 className="display-6 fw-bold text-dark">View More Photos</h3>
          </div>

          <ShootGalleryGrid images={data.gallery_images} title={data.title} />
        </div>
      </div>
    </>
  );
}
