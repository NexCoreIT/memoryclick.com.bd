import React from 'react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';

export default function TermAndConditions({ page = {} }) {
  const title = page?.title || 'Terms and Conditions';
  const body = page?.body || "<div class='text-center py-5'><h2>Terms and Conditions</h2><p class='mb-0 text-muted'>Content coming soon.</p></div>";

  return (
    <AppLayout
      title={page?.meta_title || `${title} | Memory Click`}
      metaDescription={page?.meta_description || 'Terms and conditions for Memory Click photography and cinematography services.'}
      metaKeywords={page?.meta_keywords || ''}
    >
      <Breadcrumb title={title} />

      <div className="about_sec section_gap py-5 bg-white">
        <div className="container">
          <div
            className="terms-content p-4 p-md-5 rounded shadow-sm border bg-white"
            style={{ lineHeight: '1.9', fontSize: '1.05rem' }}
            dangerouslySetInnerHTML={{ __html: body }}
          />
        </div>
      </div>
    </AppLayout>
  );
}
