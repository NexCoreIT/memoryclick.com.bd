import React from "react";
import Link from "next/link";
import { BlogItem, resolveImageUrl } from "@/lib/api";

interface HomeBlogSectionProps {
  blogs: BlogItem[];
}

export default function HomeBlogSection({ blogs }: HomeBlogSectionProps) {
  if (!blogs || blogs.length === 0) {
    return null;
  }

  return (
    <div className="blog_sec py-5 mt-4 mt-lg-5 bg-white">
      <div className="container">
        <div className="text-center mx-auto mb-5" style={{ maxWidth: "600px" }}>
          <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: "1px" }}>
            Blog & Insights
          </p>
          <h2 className="display-6 mb-3 fw-bold text-dark">
            Wedding & Photography Insights
          </h2>
          <p className="text-muted small">
            Advice and guides to help you capture every precious moment timelessly.
          </p>
        </div>

        <div className="row g-4">
          {blogs.map((blog) => (
            <div key={blog.id} className="col-md-6 col-lg-4">
              <div className="card h-100 border rounded-3 shadow-sm bg-white blog-card-item d-flex flex-column">
                <Link
                  href={`/blog/${blog.slug}`}
                  className="d-block overflow-hidden rounded-top-3"
                  style={{ height: "220px" }}
                >
                  <img
                    src={resolveImageUrl(blog.image_url || blog.image)}
                    className="card-img-top w-100 h-100 blog-img"
                    style={{ objectFit: "cover" }}
                    alt={blog.title}
                  />
                </Link>

                <div className="card-body p-4 d-flex flex-column flex-grow-1">
                  <h5 className="card-title fw-bold mb-2 fs-6">
                    <Link
                      href={`/blog/${blog.slug}`}
                      className="text-dark text-decoration-none blog-title-link"
                    >
                      {blog.title.length > 65
                        ? `${blog.title.substring(0, 65)}...`
                        : blog.title}
                    </Link>
                  </h5>

                  <p className="text-muted small mb-3 fw-semibold">
                    {blog.category?.name || "Wedding Photography"}
                  </p>

                  <p
                    className="card-text text-muted small mb-4 flex-grow-1"
                    style={{ lineHeight: "1.6" }}
                  >
                    {blog.short_description && blog.short_description.length > 130
                      ? `${blog.short_description.substring(0, 130)}...`
                      : blog.short_description}
                  </p>

                  <div className="mt-auto pt-3 border-top">
                    <Link
                      href={`/blog/${blog.slug}`}
                      className="text-dark fw-bold text-decoration-underline read-more-btn small"
                    >
                      Read More <i className="fas fa-arrow-right ms-1 text-primary" />
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>

        <div className="text-center mt-5">
          <Link className="btn btn-primary py-2 px-4 shadow-sm" href="/blog">
            View All Blogs
          </Link>
        </div>
      </div>
    </div>
  );
}
