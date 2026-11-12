import React from 'react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import { resolveImageUrl } from '@/Utils/image';

export default function About({
  meta_title = 'About Us | Memory Click',
  meta_description = '',
  meta_keywords = '',
  ceo_name = '',
  ceo_designation = 'Founder & CEO',
  ceo_image_url = '',
  ceo_body = '',
  title_2 = 'About MemoryClick',
  memoryclick_image_url = '',
  about_memoryclick = '',
  teams = [],
}) {
  return (
    <AppLayout
      title={meta_title}
      metaDescription={meta_description}
      metaKeywords={meta_keywords}
    >
      <Breadcrumb title="About Us" />

      {/* Founder & CEO Section */}
      <div className="founder_sec bg-white section_gap py-5">
        <div className="container py-lg-4">
          <div className="row d-flex align-items-center">
            {/* Image Right */}
            <div className="col-lg-6 mb-4 mb-lg-0 order-lg-2">
              <div className="about_bx text-center text-lg-end position-relative">
                <img
                  src={resolveImageUrl(ceo_image_url)}
                  className="img-fluid rounded shadow"
                  alt={ceo_name || 'Founder & CEO'}
                  style={{
                    width: '100%',
                    maxHeight: '520px',
                    objectFit: 'cover',
                    objectPosition: 'top',
                  }}
                />
              </div>
            </div>

            {/* Content Left */}
            <div className="col-lg-6 order-lg-1">
              <div className="pe-lg-5">
                <p
                  className="text-primary text-uppercase sub_title mb-2 fw-bold"
                  style={{ letterSpacing: '1px' }}
                >
                  {ceo_designation || 'CEO'}
                </p>
                <h2 className="display-6 mb-4 fw-bold text-dark">
                  {ceo_name || 'Founder & CEO'}
                </h2>
                <div
                  className="mb-4 text-muted"
                  style={{ lineHeight: '1.85', fontSize: '1.05rem', whiteSpace: 'pre-line' }}
                >
                  {ceo_body || 'Memory Click started with a vision to capture life\'s most beautiful moments. We have grown into a trusted name in wedding photography and cinematography across Bangladesh.'}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* About Memoryclick Story Section */}
      <div className="about_memoryclick section_gap bg-light py-5 border-top border-bottom">
        <div className="container py-lg-4">
          <div className="text-center mx-auto mb-5 pb-3" style={{ maxWidth: '600px' }}>
            <h2 className="display-6 fw-bold text-dark mb-3">
              {title_2 || 'About MemoryClick'}
            </h2>
            <div className="mx-auto bg-primary rounded" style={{ height: '3px', width: '60px' }} />
          </div>

          <div className="row d-flex align-items-center">
            {/* Image Left */}
            <div className="col-lg-6 mb-4 mb-lg-0 order-lg-1">
              <div className="about_bx text-center text-lg-start position-relative">
                <img
                  src={resolveImageUrl(memoryclick_image_url)}
                  className="img-fluid rounded shadow"
                  alt="Memoryclick Story"
                  style={{
                    width: '100%',
                    maxHeight: '520px',
                    objectFit: 'cover',
                  }}
                />
              </div>
            </div>

            {/* Content Right */}
            <div className="col-lg-6 order-lg-2">
              <div className="ps-lg-5">
                <p
                  className="text-primary text-uppercase sub_title mb-2 fw-bold"
                  style={{ letterSpacing: '1px' }}
                >
                  Our Journey
                </p>
                <h2 className="mb-4 fw-bold text-dark">Memoryclick Story</h2>
                <div
                  className="mb-4 text-muted"
                  style={{ lineHeight: '1.85', fontSize: '1.05rem', whiteSpace: 'pre-line' }}
                >
                  {about_memoryclick || 'Every wedding tells a unique story of love, emotion, and celebration. Our team of experienced photographers and cinematographers specialize in capturing candid, intimate, and unforgettable moments.'}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Team Member Section */}
      {teams && teams.length > 0 && (
        <div className="team_sec section_gap bg-white py-5">
          <div className="container">
            <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
              <p
                className="text-primary text-uppercase sub_title mb-2 fw-bold"
                style={{ letterSpacing: '1px' }}
              >
                Team Member
              </p>
              <h2 className="display-6 mb-4 fw-bold text-dark">Meet with our Team Member</h2>
            </div>

            <div className="row g-4">
              {teams.map((team) => (
                <div key={team.id} className="col-sm-6 col-xl-3">
                  <div className="team-membem shadow-sm bg-light p-3 p-lg-4 rounded text-center h-100 border border-light">
                    <img
                      src={resolveImageUrl(team.image_url || team.image)}
                      className="img-fluid rounded mb-3"
                      alt={team.name}
                      style={{
                        width: '100%',
                        height: '280px',
                        objectFit: 'cover',
                        objectPosition: 'top',
                      }}
                    />
                    <h5 className="fw-bold text-dark mb-1 fs-6">{team.name}</h5>
                    <p className="m-0 text-muted small">{team.designation}</p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      )}
    </AppLayout>
  );
}
