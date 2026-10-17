import React from "react";
import type { Metadata } from "next";
import Breadcrumb from "@/components/ui/Breadcrumb";
import PhotographyGallery from "@/components/photography/PhotographyGallery";
import { getPhotography } from "@/lib/api";

export const metadata: Metadata = {
  title: "Photography Portfolio | Memory Click",
  description: "Browse our wedding photography portfolio across Bangladesh.",
};

export default async function PhotographyPage() {
  const data = await getPhotography();

  return (
    <>
      <Breadcrumb title="Photography" />
      <PhotographyGallery
        categories={data.categories}
        items={data.items}
      />
    </>
  );
}
