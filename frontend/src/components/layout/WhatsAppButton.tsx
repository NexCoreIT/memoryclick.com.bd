"use client";

import React, { useEffect, useState } from "react";

interface WhatsAppButtonProps {
  phone?: string | null;
}

export default function WhatsAppButton({ phone }: WhatsAppButtonProps) {
  const [scaled, setScaled] = useState(false);

  useEffect(() => {
    const timer = setTimeout(() => {
      setScaled(true);
      const timer2 = setTimeout(() => setScaled(false), 300);
      return () => clearTimeout(timer2);
    }, 1000);
    return () => clearTimeout(timer);
  }, []);

  if (!phone) return null;

  const cleanPhone = phone.replace(/[^0-9]/g, "");

  return (
    <div className="whatsapp-button">
      <a
        href={`https://wa.me/${cleanPhone}`}
        target="_blank"
        rel="noopener noreferrer"
        className="whatsapp-float"
        style={{
          transform: scaled ? "scale(1.15)" : "scale(1)",
        }}
        aria-label="Chat on WhatsApp"
      >
        <i className="fab fa-whatsapp whatsapp-icon" />
      </a>
    </div>
  );
}
