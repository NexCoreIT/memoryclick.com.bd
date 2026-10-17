import React from "react";
import type { Metadata } from "next";
import Link from "next/link";
import Breadcrumb from "@/components/ui/Breadcrumb";
import CheckoutForm from "@/components/checkout/CheckoutForm";
import { getPackageDetails, getSettings } from "@/lib/api";

export const metadata: Metadata = {
  title: "Checkout | Memory Click",
  description: "Complete your wedding photography package booking securely.",
};

interface CheckoutPageProps {
  searchParams: Promise<{ package_id?: string }>;
}

export default async function CheckoutPage({ searchParams }: CheckoutPageProps) {
  const { package_id } = await searchParams;

  if (!package_id) {
    return (
      <>
        <Breadcrumb title="Checkout" />
        <div className="container py-5 text-center my-5">
          <div className="bg-light p-5 rounded shadow-sm border mx-auto" style={{ maxWidth: "500px" }}>
            <i className="fas fa-shopping-cart fa-3x text-primary mb-3" />
            <h4 className="fw-bold mb-2">No Package Selected</h4>
            <p className="text-muted small mb-4">
              Please choose a photography or cinematography package to proceed to checkout.
            </p>
            <Link href="/package" className="btn btn-primary px-4 py-2">
              Browse Packages
            </Link>
          </div>
        </div>
      </>
    );
  }

  let packageItem;
  let settings;

  try {
    [packageItem, settings] = await Promise.all([
      getPackageDetails(package_id),
      getSettings().catch(() => null),
    ]);
  } catch (error) {
    return (
      <>
        <Breadcrumb title="Checkout" />
        <div className="container py-5 text-center my-5">
          <div className="bg-light p-5 rounded shadow-sm border mx-auto" style={{ maxWidth: "500px" }}>
            <h4 className="fw-bold mb-2 text-danger">Package Not Found</h4>
            <p className="text-muted small mb-4">
              The requested package could not be retrieved. It may have been disabled or removed.
            </p>
            <Link href="/package" className="btn btn-primary px-4 py-2">
              Browse Other Packages
            </Link>
          </div>
        </div>
      </>
    );
  }

  return (
    <>
      <Breadcrumb
        title="Checkout"
        items={[
          { label: "Packages", href: "/package" },
          { label: "Checkout", active: true },
        ]}
      />

      <CheckoutForm
        packageItem={packageItem}
        whatsappPhone={settings?.phone}
      />
    </>
  );
}
