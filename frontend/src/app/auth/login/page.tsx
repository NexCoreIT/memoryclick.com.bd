"use client";

import React, { useState } from "react";
import Link from "next/link";
import { useRouter } from "next/navigation";
import Breadcrumb from "@/components/ui/Breadcrumb";

export default function LoginPage() {
  const router = useRouter();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
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
      const res = await fetch(`${apiUrl}/auth/login`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      });

      const data = await res.json();

      if (!res.ok) {
        throw new Error(data.message || "Invalid credentials. Please try again.");
      }

      setSuccessMsg("Login successful! Redirecting...");

      if (data.data?.token) {
        localStorage.setItem("auth_token", data.data.token);
        localStorage.setItem("auth_user", JSON.stringify(data.data.user));
      }

      if (data.data?.user?.role === "admin") {
        const backendUrl =
          process.env.NEXT_PUBLIC_BACKEND_URL ||
          "http://localhost/MyProjects/memoryclick.com.bd/public";
        window.location.href = `${backendUrl}/admin`;
      } else {
        router.push("/");
      }
    } catch (err: any) {
      setErrorMsg(err.message || "Login failed. Please check your credentials.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <Breadcrumb title="Login" />

      <div className="container py-5 my-4">
        <div className="row justify-content-center">
          <div className="col-md-7 col-lg-5">
            <div className="card shadow-sm border-0 rounded-4 bg-white p-4 p-md-5">
              <div className="text-center mb-4">
                <h3 className="fw-bold text-dark mb-1">Welcome Back</h3>
                <p className="text-muted small">
                  Sign in to your MemoryClick account
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
                    Email Address <span className="text-danger">*</span>
                  </label>
                  <input
                    type="email"
                    className="form-control shadow-none py-2"
                    placeholder="name@example.com"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                  />
                </div>

                <div className="mb-4">
                  <label className="form-label small fw-semibold text-muted">
                    Password <span className="text-danger">*</span>
                  </label>
                  <input
                    type="password"
                    className="form-control shadow-none py-2"
                    placeholder="••••••••"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
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
                      Signing in...
                    </>
                  ) : (
                    "Sign In"
                  )}
                </button>

                <div className="text-center">
                  <span className="text-muted small">
                    Don&apos;t have an account?{" "}
                    <Link
                      href="/auth/register"
                      className="text-primary fw-bold text-decoration-none"
                    >
                      Register here
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
