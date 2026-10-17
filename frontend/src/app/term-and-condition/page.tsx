import React from "react";
import type { Metadata } from "next";
import Breadcrumb from "@/components/ui/Breadcrumb";
import { getCustomPage } from "@/lib/api";

export async function generateMetadata(): Promise<Metadata> {
  try {
    const data = await getCustomPage("terms-and-condition");
    return {
      title: data.meta_title || "Terms and Conditions | Memory Click",
      description: data.meta_description || "Terms and conditions for Memory Click photography and cinematography services.",
    };
  } catch (error) {
    return {
      title: "Terms and Conditions | Memory Click",
    };
  }
}

export default async function TermsPage() {
  let page;

  try {
    page = await getCustomPage("terms-and-condition");
  } catch (error) {
    page = {
      title: "Terms and Condition",
      body: "<div class='text-center py-5'><h2>Terms and Condition</h2><p class='mb-0 text-muted'>Content coming soon.</p></div>",
    };
  }

  return (
    <>
      <Breadcrumb title={page.title || "Terms and Condition"} />

      <div className="about_sec section_gap py-5 bg-white">
        <div className="container">
          <div
            className="terms-content p-4 p-md-5 rounded shadow-sm border bg-white"
            style={{ lineHeight: "1.9", fontSize: "1.05rem" }}
            dangerouslySetInnerHTML={{ __html: page.body }}
          />
        </div>
      </div>
    </>
  );
}
