import React from "react";
import type { Metadata } from "next";
import Link from "next/link";
import Breadcrumb from "@/components/ui/Breadcrumb";

export const metadata: Metadata = {
  title: "Payment Failed | Memory Click",
  description: "Payment transaction could not be completed.",
};

interface PaymentFailPageProps {
  params: Promise<{ tran_id: string }>;
}

export default async function PaymentFailPage({ params }: PaymentFailPageProps) {
  const { tran_id } = await params;

  return (
    <>
      <Breadcrumb title="Payment Failed" />

      <div className="container py-5 my-4">
        <div className="row justify-content-center">
          <div className="col-md-8 col-lg-6">
            <div className="card shadow-sm border-0 rounded-4 text-center p-4 p-md-5 bg-white">
              <div className="mb-4">
                <div
                  className="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                  style={{ width: "90px", height: "90px" }}
                >
                  <i className="fas fa-times-circle text-danger fs-1" />
                </div>
              </div>

              <h2 className="fw-bold text-dark mb-2">Payment Failed</h2>
              <p className="text-muted mb-4">
                We could not complete your transaction. Your account has not been charged, or the payment gateway encountered an issue.
              </p>

              <div className="bg-light p-3 rounded-3 text-start mb-4">
                <div className="d-flex justify-content-between">
                  <span className="text-muted small">Transaction Reference:</span>
                  <span className="fw-semibold text-danger small">{tran_id}</span>
                </div>
              </div>

              <div className="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                <Link href="/package" className="btn btn-primary px-4 py-2">
                  Try Again
                </Link>
                <Link href="/contact-us" className="btn btn-outline-dark px-4 py-2">
                  Contact Support
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
