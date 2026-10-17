import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  images: {
    unoptimized: true,
    remotePatterns: [
      {
        protocol: "http",
        hostname: "localhost",
      },
      {
        protocol: "http",
        hostname: "127.0.0.1",
      },
      {
        protocol: "https",
        hostname: "**",
      },
    ],
  },
  async redirects() {
    const backendUrl =
      process.env.NEXT_PUBLIC_BACKEND_URL || "http://127.0.0.1:8000";
    return [
      {
        source: "/admin",
        destination: `${backendUrl}/admin`,
        permanent: false,
      },
      {
        source: "/admin/:path*",
        destination: `${backendUrl}/admin/:path*`,
        permanent: false,
      },
    ];
  },
};

export default nextConfig;
