import type { Metadata } from "next";
import "./globals.css";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import WhatsAppButton from "@/components/layout/WhatsAppButton";
import TrackingScripts from "@/components/layout/TrackingScripts";
import { getSettings, SiteSettings } from "@/lib/api";

export async function generateMetadata(): Promise<Metadata> {
  try {
    const settings = await getSettings();
    return {
      title: {
        default: settings.meta_title || "Memory Click | Best Wedding Photographer in Bangladesh",
        template: "%s | Memory Click",
      },
      description:
        settings.meta_description ||
        "Premium wedding photography and cinematography company based in Bangladesh",
      keywords:
        settings.meta_keywords ||
        "wedding photography, cinematography, bridal shoot, memory click",
      icons: {
        icon: settings.favicon_url || "/fav.png",
        shortcut: settings.favicon_url || "/fav.png",
      },
      openGraph: {
        title: settings.meta_title || "Memory Click",
        description:
          settings.meta_description ||
          "Premium wedding photography and cinematography company based in Bangladesh",
        images: [
          {
            url: settings.meta_image_url || "/fav.png",
            alt: "Memory Click",
          },
        ],
      },
    };
  } catch (error) {
    return {
      title: "Memory Click | Best Wedding Photographer in Bangladesh",
      description: "Premium wedding photography and cinematography company based in Bangladesh",
      icons: { icon: "/fav.png" },
    };
  }
}

export default async function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  let settings: SiteSettings | null = null;
  try {
    settings = await getSettings();
  } catch (error) {
    console.warn("Could not load settings on initial layout render", error);
  }

  return (
    <html lang="en">
      <head>
        <link rel="icon" href="/fav.png" />
      </head>
      <body>
        <TrackingScripts settings={settings} />
        <Header settings={settings} />
        <main>{children}</main>
        <WhatsAppButton phone={settings?.phone} />
        <Footer settings={settings} />
      </body>
    </html>
  );
}
