import React from "react";
import type { Metadata } from "next";
import Link from "next/link";
import Breadcrumb from "@/components/ui/Breadcrumb";
import BlogSearchFilter from "@/components/blog/BlogSearchFilter";
import { getBlogs, resolveImageUrl } from "@/lib/api";

export const metadata: Metadata = {
  title: "Blog & Stories | Memory Click",
  description: "Discover event photography tips, wedding cinematography trends, and studio stories.",
};

interface BlogPageProps {
  searchParams: Promise<{
    category?: string;
    search?: string;
    page?: string;
  }>;
}

export default async function BlogPage({ searchParams }: BlogPageProps) {
  const { category, search, page } = await searchParams;
  const currentPage = page ? parseInt(page, 10) : 1;

  const data = await getBlogs({
    category,
    search,
    page: currentPage,
    per_page: 9,
  });

  return (
    <>
      <Breadcrumb title="Blog & Stories" />

      <div className="blog_sec section_gap py-5">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: "600px" }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: "1px" }}>
              Our Blog
            </p>
            <h1 className="display-6 mb-3 fw-bold text-dark">
              Explore Latest Photography & Cinematography Stories
            </h1>
          </div>

          {/* Filter Bar with Categories and Search */}
          <BlogSearchFilter
            categories={data.categories}
            selectedCategory={category}
            initialSearch={search}
          />

          {/* Blog Cards Grid */}
          <div className="row g-4">
            {data.posts.length === 0 ? (
              <div className="col-12 text-center py-5">
                <div className="bg-light p-5 rounded shadow-sm border text-muted mx-auto" style={{ maxWidth: "500px" }}>
                  <i className="fas fa-newspaper fa-3x text-primary mb-3" />
                  <h4 className="text-dark fw-bold mb-2">No Blog Posts Found</h4>
                  <p className="mb-0 small">
                    There are currently no blog articles matching your search criteria.
                  </p>
                </div>
              </div>
            ) : (
              data.posts.map((post) => (
                <div key={post.id} className="col-12 col-sm-6 col-lg-4">
                  <div className="blog_card h-100 bg-white border rounded shadow-sm d-flex flex-column">
                    <div className="blog_card_img_wrap position-relative" style={{ height: "220px", overflow: "hidden" }}>
                      {post.category && (
                        <span className="blog_badge position-absolute top-0 start-0 m-2 px-2 py-1 bg-primary text-white rounded small fw-bold" style={{ zIndex: 2 }}>
                          {post.category.name}
                        </span>
                      )}

                      <Link href={`/blog/${post.slug}`} className="d-block w-100 h-100">
                        <img
                          src={resolveImageUrl(post.image_url || post.image)}
                          alt={post.title}
                          className="w-100 h-100"
                          style={{ objectFit: "cover", transition: "transform 0.4s ease" }}
                        />
                      </Link>
                    </div>

                    <div className="blog_card_body p-4 d-flex flex-column flex-grow-1">
                      <div className="blog_meta d-flex gap-3 text-muted small mb-2">
                        <span>
                          <i className="far fa-user text-primary me-1" />
                          {post.author_name || "MemoryClick"}
                        </span>
                        <span>
                          <i className="far fa-calendar-alt text-primary me-1" />
                          {post.created_at || "Recent"}
                        </span>
                        <span>
                          <i className="far fa-eye text-primary me-1" />
                          {post.views}
                        </span>
                      </div>

                      <h3 className="blog_card_title fs-6 fw-bold mb-2">
                        <Link
                          href={`/blog/${post.slug}`}
                          className="text-dark text-decoration-none"
                        >
                          {post.title}
                        </Link>
                      </h3>

                      <p className="blog_card_desc text-muted small flex-grow-1" style={{ lineHeight: "1.6" }}>
                        {post.short_description?.length && post.short_description.length > 110
                          ? `${post.short_description.substring(0, 110)}...`
                          : post.short_description}
                      </p>

                      <div className="pt-3 border-top mt-auto">
                        <Link href={`/blog/${post.slug}`} className="blog_read_more text-primary fw-bold text-decoration-none small">
                          Read Article <i className="fas fa-arrow-right ms-1" />
                        </Link>
                      </div>
                    </div>
                  </div>
                </div>
              ))
            )}
          </div>

          {/* Pagination */}
          {data.pagination && data.pagination.last_page > 1 && (
            <div className="d-flex justify-content-center mt-5 gap-2">
              {Array.from({ length: data.pagination.last_page }, (_, i) => i + 1).map((pageNum) => {
                const params = new URLSearchParams();
                if (category) params.set("category", category);
                if (search) params.set("search", search);
                params.set("page", pageNum.toString());

                const isActive = pageNum === data.pagination.current_page;

                return (
                  <Link
                    key={pageNum}
                    href={`/blog?${params.toString()}`}
                    className={`btn btn-sm px-3 py-2 ${
                      isActive ? "btn-primary" : "btn-outline-secondary"
                    }`}
                  >
                    {pageNum}
                  </Link>
                );
              })}
            </div>
          )}
        </div>
      </div>
    </>
  );
}
