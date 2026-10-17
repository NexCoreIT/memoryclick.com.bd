import React from "react";
import type { Metadata } from "next";
import { notFound } from "next/navigation";
import Breadcrumb from "@/components/ui/Breadcrumb";
import DivisionPackagesView from "@/components/package/DivisionPackagesView";
import { getDivisionPackages, getSettings } from "@/lib/api";

interface DivisionPackagePageProps {
  params: Promise<{ slug: string }>;
}

export async function generateMetadata({
  params,
}: DivisionPackagePageProps): Promise<Metadata> {
  const { slug } = await params;
  try {
    const data = await getDivisionPackages(slug);
    return {
      title: `${data.division.name} Packages | Memory Click`,
      description: `Explore photography and cinematography packages available in ${data.division.name}.`,
    };
  } catch (error) {
    return {
      title: "Division Packages | Memory Click",
    };
  }
}

export default async function DivisionPackagePage({
  params,
}: DivisionPackagePageProps) {
  const { slug } = await params;
  let data;
  let settings;

  try {
    [data, settings] = await Promise.all([
      getDivisionPackages(slug),
      getSettings().catch(() => null),
    ]);
  } catch (error) {
    notFound();
  }

  return (
    <>
      <Breadcrumb
        title={`${data.division.name} Packages`}
        items={[
          { label: "Packages", href: "/package" },
          { label: `${data.division.name} Packages`, active: true },
        ]}
      />

      <DivisionPackagesView
        division={data.division}
        categories={data.categories}
        packages={data.packages}
        whatsappPhone={settings?.phone}
      />
    </>
  );
}
