"use client";

import React, { useState } from "react";
import Link from "next/link";
import { useRouter } from "next/navigation";
import Breadcrumb from "@/components/ui/Breadcrumb";

export default function RegisterPage() {
  const router = useRouter();
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    password: "",
  });
  const [imageFile, setImageFile] = useState<File | null>(null);
  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState("");
  const [successMsg, setSuccessMsg] = useState("");

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setErrorMsg("");
    setSuccessMsg("");

    const apiUrl =
      process.env.NEXT_PUBLIC_API_URL ||
      "http://localhost/MyProjects/memoryclick.com.bd/public/api";

    try {
      const data = new FormData();
      data.append("name", formData.name);
      data.append("email", formData.email);
      data.append("phone", formData.phone);
      data.append("password", formData.password);
      if (imageFile) {
        data.append("image", imageFile);
      }

      const res = await fetch(`${apiUrl}/auth/register`, {
        method: "POST",
        headers: {
          Accept: "application/json",
        },
        body: data,
      });

      const json = await res.json();

      if (!res.ok) {
        throw new Error(json.message || "Registration failed. Please try again.");
      }

      setSuccessMsg("Registration successful! Redirecting...");

      if (json.data?.token) {
        localStorage.setItem("auth_token", json.data.token);
        localStorage.setItem("auth_user", JSON.stringify(json.data.user));
      }

      setTimeout(() => {
        router.push("/");
      }, 1000);
    } catch (err: any) {
      setErrorMsg(err.message || "Registration failed. Please check your data.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <Breadcrumb title="Register" />

      <div className="container py-5 my-4">
        <div className="row justify-content-center">
          <div className="col-md-8 col-lg-6">
            <div className="card shadow-sm border-0 rounded-4 bg-white p-4 p-md-5">
              <div className="text-center mb-4">
                <h3 className="fw-bold text-dark mb-1">Create an Account</h3>
                <p className="text-muted small">
                  Join MemoryClick to manage your event bookings
                </p>
              </div>

              {errorMsg && (
                <div className="alert alert-danger d-flex align-items-center mb-4 small">
                  <i className="fas fa-exclamation-triangle me-2" />
                  <span>{errorMsg}</span>
                </div>
              )}

              {successMsg && (
                <div className="alert alert-success d-flex align-items-center mb-4 small">
                  <i className="fas fa-check-circle me-2" />
                  <span>{successMsg}</span>
                </div>
              )}

              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label className="form-label small fw-semibold text-muted">
                    Full Name <span className="text-danger">*</span>
                  </label>
                  <input
                    type="text"
                    className="form-control shadow-none py-2"
                    placeholder="Your Name"
                    value={formData.name}
                    onChange={(e) =>
                      setFormData({ ...formData, name: e.target.value })
                    }
                    required
                  />
                </div>

                <div className="mb-3">
                  <label className="form-label small fw-semibold text-muted">
                    Email Address <span className="text-danger">*</span>
                  </label>
                  <input
                    type="email"
                    className="form-control shadow-none py-2"
                    placeholder="name@example.com"
                    value={formData.email}
                    onChange={(e) =>
                      setFormData({ ...formData, email: e.target.value })
                    }
                    required
                  />
                </div>

                <div className="mb-3">
                  <label className="form-label small fw-semibold text-muted">
                    Phone Number <span className="text-danger">*</span>
                  </label>
                  <input
                    type="tel"
                    className="form-control shadow-none py-2"
                    placeholder="01XXXXXXXXX"
                    value={formData.phone}
                    onChange={(e) =>
                      setFormData({ ...formData, phone: e.target.value })
                    }
                    required
                  />
                </div>

                <div className="mb-3">
                  <label className="form-label small fw-semibold text-muted">
                    Password <span className="text-danger">*</span>
                  </label>
                  <input
                    type="password"
                    className="form-control shadow-none py-2"
                    placeholder="Minimum 6 characters"
                    value={formData.password}
                    onChange={(e) =>
                      setFormData({ ...formData, password: e.target.value })
                    }
                    required
                  />
                </div>

                <div className="mb-4">
                  <label className="form-label small fw-semibold text-muted">
                    Profile Photo (Optional)
                  </label>
                  <input
                    type="file"
                    className="form-control shadow-none py-2"
                    accept="image/*"
                    onChange={(e) => {
                      if (e.target.files && e.target.files[0]) {
                        setImageFile(e.target.files[0]);
                      }
                    }}
                  />
                </div>

                <button
                  type="submit"
                  disabled={loading}
                  className="btn btn-primary w-100 py-2 fw-semibold shadow-sm mb-3"
                >
                  {loading ? (
                    <>
                      <span className="spinner-border spinner-border-sm me-2" />
                      Creating account...
                    </>
                  ) : (
                    "Register"
                  )}
                </button>

                <div className="text-center">
                  <span className="text-muted small">
                    Already have an account?{" "}
                    <Link
                      href="/auth/login"
                      className="text-primary fw-bold text-decoration-none"
                    >
                      Login here
                    </Link>
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
