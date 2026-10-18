import React from 'react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import HomeContactSection from '@/Components/Home/HomeContactSection';

export default function Contact({ contact = {} }) {
  return (
    <AppLayout
      title="Contact Us | Memory Click"
      metaDescription="Get in touch with Memory Click studio for wedding and event photography bookings."
    >
      <Breadcrumb title="Contact Us" />
      <HomeContactSection contact={contact} />
    </AppLayout>
  );
}
