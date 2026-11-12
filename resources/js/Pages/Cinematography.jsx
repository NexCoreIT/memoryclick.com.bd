import React from 'react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import { getEmbedUrl } from '@/Components/Home/CinematographyCarousel';

export default function Cinematography({ videos = [] }) {
  return (
    <AppLayout
      title="Cinematography Portfolio | Memory Click"
      metaDescription="Watch our stunning wedding films and cinematography reels."
    >
      <Breadcrumb title="Cinematography" />

      <div className="cinematography_sec section_gap py-5 bg-white">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
              Cinematography
            </p>
            <h1 className="display-6 mb-4 fw-bold text-dark">See our all Cinematography</h1>
          </div>

          {videos.length === 0 ? (
            <div className="text-center py-5">
              <div className="bg-light p-5 rounded shadow-sm border mx-auto" style={{ maxWidth: '500px' }}>
                <i className="fas fa-video fa-3x text-primary mb-3" />
                <h4 className="fw-bold mb-2">No Videos Found</h4>
                <p className="text-muted small mb-0">No cinematography videos found at this time.</p>
              </div>
            </div>
          ) : (
            <div className="row gy-4">
              {videos.map((video) => (
                <div key={video.id} className="col-sm-6 col-lg-4 col-xl-3">
                  <div className="testimonial-item shadow-sm p-3 rounded bg-white text-center h-100 d-flex flex-column border">
                    <div className="ratio ratio-16x9 mb-3 rounded overflow-hidden shadow-sm bg-dark">
                      <iframe
                        width="100%"
                        height="100%"
                        src={getEmbedUrl(video.youtube_url)}
                        title={video.title || 'Cinematography'}
                        frameBorder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowFullScreen
                        loading="lazy"
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
          )}
        </div>
      </div>
    </AppLayout>
  );
}
