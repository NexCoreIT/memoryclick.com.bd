import React from "react";
import type { Metadata } from "next";
import Breadcrumb from "@/components/ui/Breadcrumb";
import { getCinematography } from "@/lib/api";

export const metadata: Metadata = {
  title: "Cinematography Portfolio | Memory Click",
  description: "Watch our stunning wedding films and cinematography reels.",
};

function getEmbedUrl(rawUrl: string): string {
  if (!rawUrl) return "";

  if (rawUrl.includes("youtube.com/watch?v=")) {
    const videoId = rawUrl.split("watch?v=")[1]?.split("&")[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }

  if (rawUrl.includes("youtu.be/")) {
    const videoId = rawUrl.split("youtu.be/")[1]?.split("?")[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }

  return `https://www.facebook.com/plugins/video.php?href=${encodeURIComponent(
    rawUrl
  )}&show_text=false&width=560`;
}

export default async function CinematographyPage() {
  const videos = await getCinematography();

  return (
    <>
      <Breadcrumb title="Cinematography" />

      <div className="cinematography_sec section_gap py-5">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: "600px" }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: "1px" }}>
              Cinematography
            </p>
            <h1 className="display-6 mb-4 fw-bold text-dark">See our all Cinematography</h1>
          </div>

          <div className="row gy-4">
            {videos.map((video) => (
              <div key={video.id} className="col-sm-6 col-lg-4 col-xl-3">
                <div className="testimonial-item shadow-sm p-3 rounded bg-white text-center h-100 d-flex flex-column border">
                  <div className="ratio ratio-16x9 mb-3 rounded overflow-hidden shadow-sm bg-dark">
                    <iframe
                      width="100%"
                      height="100%"
                      src={getEmbedUrl(video.youtube_url)}
                      title={video.title || "Cinematography"}
                      frameBorder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowFullScreen
                    />
                  </div>

                  <div className="flex-grow-1 d-flex flex-column justify-content-between">
                    <h5 className="mb-2 fs-6 fw-bold text-dark">
                      <strong>{video.title}</strong>
                    </h5>
                    {video.credit && (
                      <p className="m-0 text-muted small">
                        Film Credits: <span className="fw-semibold text-primary">{video.credit}</span>
                      </p>
                    )}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </>
  );
}
