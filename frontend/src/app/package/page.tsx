import React from "react";
import type { Metadata } from "next";
import Link from "next/link";
import Breadcrumb from "@/components/ui/Breadcrumb";
import { getPackageDivisions, resolveImageUrl } from "@/lib/api";

export const metadata: Metadata = {
  title: "Packages | Memory Click",
  description: "Browse our photography and cinematography packages by division in Bangladesh.",
};

export default async function PackageDivisionsPage() {
  const divisions = await getPackageDivisions();

  return (
    <>
      <Breadcrumb title="Packages" />

      <div className="section_gap py-5">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: "600px" }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: "1px" }}>
              Divisions
            </p>
            <h1 className="display-6 mb-3 fw-bold text-dark">Select Your Event Location</h1>
            <p className="text-muted small">
              Choose your division to explore tailored photography & cinematography packages.
            </p>
          </div>

          <div className="row justify-content-center">
            <div className="col-lg-8">
              <div className="row gy-4">
                {divisions.map((division) => (
                  <div key={division.id} className="col-md-6">
                    <div className="package_wrap h-100 text-center position-relative overflow-hidden border rounded shadow-sm bg-white p-3 hover-shadow transition">
                      <div className="overflow-hidden rounded-top mb-3" style={{ height: "220px" }}>
                        <img
                          src={resolveImageUrl(division.image_url || division.image)}
                          className="w-100 h-100 rounded-top"
                          alt={division.name}
                          style={{ objectFit: "cover" }}
                        />
                      </div>
                      <h4 className="fw-bold mb-2">
                        <Link
                          href={`/division/${division.slug}/package`}
                          className="stretched-link text-decoration-none text-dark"
                        >
                          {division.name} Packages
                        </Link>
                      </h4>
                      <p className="text-muted small mb-0">
                        {division.packages_count} Available Packages
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
