import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import Header from './Header';
import Footer from './Footer';
import WhatsAppButton from './WhatsAppButton';

export default function AppLayout({ title, metaDescription, metaKeywords, children }) {
  const { props } = usePage();
  const settings = props.settings;

  const pageTitle = title || settings?.meta_title || 'Memory Click | Best Wedding Photographer in Bangladesh';
  const description = metaDescription || settings?.meta_description || '';
  const keywords = metaKeywords || settings?.meta_keywords || '';

  return (
    <>
      <Head>
        <title>{pageTitle}</title>
        {description && <meta name="description" content={description} />}
        {keywords && <meta name="keywords" content={keywords} />}
        {settings?.meta_image_url && <meta property="og:image" content={settings.meta_image_url} />}
      </Head>

      <Header />
      <main>{children}</main>
      <Footer />
      <WhatsAppButton />
    </>
  );
}
