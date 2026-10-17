import React from "react";
import Script from "next/script";
import { SiteSettings } from "@/lib/api";

interface TrackingScriptsProps {
  settings?: SiteSettings | null;
}

export default function TrackingScripts({ settings }: TrackingScriptsProps) {
  if (!settings) return null;

  return (
    <>
      {/* Google Search Console */}
      {settings.google_search_console_code && (
        <div
          dangerouslySetInnerHTML={{
            __html: settings.google_search_console_code,
          }}
        />
      )}

      {/* Google Analytics (GTAG) */}
      {settings.google_analytics_code ? (
        <div
          dangerouslySetInnerHTML={{
            __html: settings.google_analytics_code,
          }}
        />
      ) : settings.google_analytics_id ? (
        <>
          <Script
            src={`https://www.googletagmanager.com/gtag/js?id=${settings.google_analytics_id}`}
            strategy="afterInteractive"
          />
          <Script id="google-analytics" strategy="afterInteractive">
            {`
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', '${settings.google_analytics_id}');
            `}
          </Script>
        </>
      ) : null}

      {/* Google / Meta Pixel */}
      {settings.google_pixel_code ? (
        <div
          dangerouslySetInnerHTML={{
            __html: settings.google_pixel_code,
          }}
        />
      ) : settings.google_pixel_id ? (
        <Script id="facebook-pixel" strategy="afterInteractive">
          {`
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '${settings.google_pixel_id}');
            fbq('track', 'PageView');
          `}
        </Script>
      ) : null}

      {/* Custom Head Code */}
      {settings.custom_head_code && (
        <div
          dangerouslySetInnerHTML={{
            __html: settings.custom_head_code,
          }}
        />
      )}
    </>
  );
}
