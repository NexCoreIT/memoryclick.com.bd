import React from "react";
import type { Metadata } from "next";
import Breadcrumb from "@/components/ui/Breadcrumb";
import HomeContactSection from "@/components/home/HomeContactSection";
import { getSettings } from "@/lib/api";

export const metadata: Metadata = {
  title: "Contact Us | Memory Click",
  description: "Get in touch with Memory Click studio for wedding and event photography bookings.",
};

export default async function ContactUsPage() {
  const settings = await getSettings().catch(() => null);

  const contactData = {
    phone: settings?.phone || "",
    email: settings?.email || "",
    address: settings?.address || "",
    google_map: settings?.google_map || "",
  };

  return (
    <>
      <Breadcrumb title="Contact Us" />
      <HomeContactSection contact={contactData} />
    </>
  );
}
