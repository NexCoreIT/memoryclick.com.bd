import React from 'react';
import { Link } from '@inertiajs/react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import { resolveImageUrl } from '@/Utils/image';

export default function BlogDetails({
  post,
  seo = {},
  categories = [],
  related_posts = [],
}) {
  if (!post) return null;

  const currentUrl = typeof window !== 'undefined' ? window.location.href : '';

  return (
    <AppLayout
      title={seo?.meta_title || `${post.title} | Memory Click`}
      metaDescription={seo?.meta_description || post.short_description || ''}
      metaKeywords={seo?.meta_keywords || ''}
    >
      <Breadcrumb
        title={post.title}
        items={[
          { label: 'Blog', href: '/blog' },
          { label: post.title, active: true },
        ]}
      />

      <div className="blog_details_sec section_gap py-5 bg-light">
        <div className="container">
          <div className="row g-4">
            {/* Main Article Content */}
            <div className="col-lg-8">
              <article className="blog_details_card bg-white p-4 p-md-5 rounded shadow-sm border">
                {post.category && (
                  <span className="blog_details_badge mb-3">
                    {post.category.name}
                  </span>
                )}

                <h1 className="blog_details_title mb-3 fw-bold text-dark">
                  {post.title}
                </h1>

                <div className="d-flex flex-wrap gap-3 text-muted small mb-4 pb-3 border-bottom">
                  <span>
                    <i className="far fa-user text-primary me-1" />
                    {post.author_name || 'MemoryClick Studio'}
                  </span>
                  <span>
                    <i className="far fa-calendar-alt text-primary me-1" />
                    {post.created_at}
                  </span>
                  <span>
                    <i className="far fa-eye text-primary me-1" />
                    {post.views ?? 0} Views
                  </span>
                </div>

                {/* Featured Image */}
                <div className="mb-4 overflow-hidden rounded shadow-sm">
                  <img
                    src={resolveImageUrl(post.image_url || post.image)}
                    alt={post.title}
                    className="w-100 rounded"
                    style={{ maxHeight: '500px', objectFit: 'cover' }}
                  />
                </div>

                {/* Article Body */}
                <div
                  className="article-content text-dark mb-5"
                  style={{ lineHeight: '1.9', fontSize: '1.08rem' }}
                  dangerouslySetInnerHTML={{ __html: post.description || '' }}
                />

                {/* Social Share */}
                <div className="pt-4 border-top d-flex align-items-center justify-content-between flex-wrap gap-3">
                  <span className="fw-semibold text-dark">Share this article:</span>
                  <div className="d-flex gap-2">
                    <a
                      href={`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="btn btn-sm btn-outline-primary rounded-circle d-flex align-items-center justify-content-center"
                      style={{ width: '36px', height: '36px' }}
                      aria-label="Share on Facebook"
                    >
                      <i className="fab fa-facebook-f" />
                    </a>
                    <a
                      href={`https://twitter.com/intent/tweet?text=${encodeURIComponent(post.title)}`}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="btn btn-sm btn-outline-primary rounded-circle d-flex align-items-center justify-content-center"
                      style={{ width: '36px', height: '36px' }}
                      aria-label="Share on Twitter"
                    >
                      <i className="fab fa-twitter" />
                    </a>
                    <a
                      href={`https://api.whatsapp.com/send?text=${encodeURIComponent(post.title)}`}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="btn btn-sm btn-outline-success rounded-circle d-flex align-items-center justify-content-center"
                      style={{ width: '36px', height: '36px' }}
                      aria-label="Share on WhatsApp"
                    >
                      <i className="fab fa-whatsapp" />
                    </a>
                  </div>
                </div>
              </article>
            </div>

            {/* Sidebar */}
            <div className="col-lg-4">
              {/* Categories Widget */}
              {categories && categories.length > 0 && (
                <div className="card shadow-sm border-0 mb-4 bg-white p-4">
                  <h5 className="fw-bold mb-3 text-dark border-bottom pb-2">
                    Categories
                  </h5>
                  <ul className="list-unstyled mb-0">
                    {categories.map((cat) => (
                      <li key={cat.id} className="py-2 border-bottom d-flex justify-content-between align-items-center">
                        <Link
                          href={`/blog?category=${cat.slug}`}
                          className="text-decoration-none text-muted fw-semibold small"
                        >
                          {cat.name}
                        </Link>
                        <span className="badge bg-light text-dark rounded-pill">
                          {cat.posts_count}
                        </span>
                      </li>
                    ))}
                  </ul>
                </div>
              )}

              {/* Related Posts Widget */}
              {related_posts && related_posts.length > 0 && (
                <div className="card shadow-sm border-0 bg-white p-4">
                  <h5 className="fw-bold mb-3 text-dark border-bottom pb-2">
                    Recent Stories
                  </h5>
                  <div className="d-flex flex-column gap-3">
                    {related_posts.map((rp) => (
                      <div key={rp.id} className="d-flex gap-3 align-items-center">
                        <div
                          className="flex-shrink-0 rounded overflow-hidden"
                          style={{ width: '70px', height: '70px' }}
                        >
                          <img
                            src={resolveImageUrl(rp.image_url || rp.image)}
                            alt={rp.title}
                            className="w-100 h-100"
                            style={{ objectFit: 'cover' }}
                          />
                        </div>
                        <div>
                          <h6 className="mb-1 small fw-bold">
                            <Link
                              href={`/blog/${rp.slug}`}
                              className="text-dark text-decoration-none"
                            >
                              {rp.title.length > 45
                                ? `${rp.title.substring(0, 45)}...`
                                : rp.title}
                            </Link>
                          </h6>
                          <small className="text-muted">{rp.created_at}</small>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
