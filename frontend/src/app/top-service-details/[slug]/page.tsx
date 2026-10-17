import React from "react";
import type { Metadata } from "next";
import { notFound } from "next/navigation";
import Breadcrumb from "@/components/ui/Breadcrumb";
import { getServiceDetails, resolveImageUrl } from "@/lib/api";

interface ServiceDetailsPageProps {
  params: Promise<{ slug: string }>;
}

export async function generateMetadata({
  params,
}: ServiceDetailsPageProps): Promise<Metadata> {
  const { slug } = await params;
  try {
    const service = await getServiceDetails(slug);
    return {
      title: `${service.title} | Memory Click`,
      description: service.description?.substring(0, 160) || "Service Details",
    };
  } catch (error) {
    return {
      title: "Service Details | Memory Click",
    };
  }
}

export default async function ServiceDetailsPage({
  params,
}: ServiceDetailsPageProps) {
  const { slug } = await params;
  let service;

  try {
    service = await getServiceDetails(slug);
  } catch (error) {
    notFound();
  }

  return (
    <>
      <Breadcrumb
        title="All Services"
        items={[
          { label: "All Services", href: "/all-service" },
          { label: service.title, active: true },
        ]}
      />

      <div className="service_sec section_gap py-5">
        <div className="container">
          <div className="text-center mx-auto" style={{ maxWidth: "800px" }}>
            <h1 className="display-6 mb-4 fw-bold text-dark">{service.title}</h1>
            <div className="mb-4 overflow-hidden rounded shadow-sm">
              <img
                src={resolveImageUrl(service.image_url || service.image)}
                className="img-fluid rounded w-100"
                alt={service.title}
                style={{ maxHeight: "480px", objectFit: "cover" }}
              />
            </div>
            <p className="text-muted text-start" style={{ lineHeight: "1.9", fontSize: "1.1rem", whiteSpace: "pre-line" }}>
              {service.description}
            </p>
          </div>
        </div>
      </div>
    </>
  );
}
