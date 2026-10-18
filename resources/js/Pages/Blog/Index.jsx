import React, { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AppLayout from '@/Components/Layout/AppLayout';
import Breadcrumb from '@/Components/UI/Breadcrumb';
import { resolveImageUrl } from '@/Utils/image';

export default function BlogIndex({
  posts = [],
  categories = [],
  pagination = {},
  selected_category,
  search_query = '',
}) {
  const [searchTerm, setSearchTerm] = useState(search_query);

  const handleSearch = (e) => {
    e.preventDefault();
    router.get(
      '/blog',
      {
        search: searchTerm.trim() || undefined,
        category: selected_category || undefined,
        page: 1,
      },
      { preserveState: true }
    );
  };

  const handleCategoryClick = (categorySlug) => {
    router.get(
      '/blog',
      {
        category: categorySlug === 'all' ? undefined : categorySlug,
        search: searchTerm.trim() || undefined,
        page: 1,
      },
      { preserveState: true }
    );
  };

  return (
    <AppLayout
      title="Blog & Stories | Memory Click"
      metaDescription="Discover event photography tips, wedding cinematography trends, and studio stories."
    >
      <Breadcrumb title="Blog & Stories" />

      <div className="blog_sec section_gap py-5">
        <div className="container">
          <div className="text-center mx-auto mb-5" style={{ maxWidth: '600px' }}>
            <p className="text-primary text-uppercase sub_title mb-2 fw-bold" style={{ letterSpacing: '1px' }}>
              Our Blog
            </p>
            <h1 className="display-6 mb-3 fw-bold text-dark">
              Explore Latest Photography & Cinematography Stories
            </h1>
          </div>

          {/* Search & Categories Filter Bar */}
          <div className="row align-items-center justify-content-between mb-4 gy-3">
            <div className="col-lg-8 text-center text-lg-start d-flex flex-wrap gap-2">
              <button
                type="button"
                onClick={() => handleCategoryClick('all')}
                className={`btn btn-default shadow-none border-0 bg-transparent filter-button px-3 py-2 ${
                  !selected_category || selected_category === 'all' ? 'active' : 'text-muted'
                }`}
              >
                All
              </button>
              {categories.map((cat) => (
                <button
                  key={cat.id}
                  type="button"
                  onClick={() => handleCategoryClick(cat.slug)}
                  className={`btn btn-default shadow-none border-0 bg-transparent filter-button px-3 py-2 ${
                    selected_category === cat.slug ? 'active' : 'text-muted'
                  }`}
                >
                  {cat.name} ({cat.posts_count ?? 0})
                </button>
              ))}
            </div>

            <div className="col-lg-4">
              <form onSubmit={handleSearch}>
                <div className="input-group">
                  <input
                    type="text"
                    name="search"
                    className="form-control shadow-none rounded-start border"
                    placeholder="Search articles..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                  />
                  <button className="btn btn-primary px-3 text-white" type="submit">
                    <i className="fas fa-search" />
                  </button>
                </div>
              </form>
            </div>
          </div>

          {/* Blog Cards Grid */}
          <div className="row g-4">
            {posts.length === 0 ? (
              <div className="col-12 text-center py-5">
                <div className="bg-light p-5 rounded shadow-sm border text-muted mx-auto" style={{ maxWidth: '500px' }}>
                  <i className="fas fa-newspaper fa-3x text-primary mb-3" />
                  <h4 className="text-dark fw-bold mb-2">No Blog Posts Found</h4>
                  <p className="mb-0 small">
                    There are currently no blog articles matching your search criteria.
                  </p>
                </div>
              </div>
            ) : (
              posts.map((post) => (
                <div key={post.id} className="col-12 col-sm-6 col-lg-4">
                  <div className="blog_card h-100 bg-white border rounded shadow-sm d-flex flex-column">
                    <div className="blog_card_img_wrap position-relative" style={{ height: '220px', overflow: 'hidden' }}>
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
                          style={{ objectFit: 'cover', transition: 'transform 0.4s ease' }}
                        />
                      </Link>
                    </div>

                    <div className="blog_card_body p-4 d-flex flex-column flex-grow-1">
                      <div className="blog_meta d-flex gap-3 text-muted small mb-2">
                        <span>
                          <i className="far fa-user text-primary me-1" />
                          {post.author_name || 'MemoryClick'}
                        </span>
                        <span>
                          <i className="far fa-calendar-alt text-primary me-1" />
                          {post.created_at || 'Recent'}
                        </span>
                        <span>
                          <i className="far fa-eye text-primary me-1" />
                          {post.views ?? 0}
                        </span>
                      </div>

                      <h5 className="card-title fw-bold mb-2 fs-6">
                        <Link
                          href={`/blog/${post.slug}`}
                          className="text-dark text-decoration-none blog-title-link"
                        >
                          {post.title.length > 65
                            ? `${post.title.substring(0, 65)}...`
                            : post.title}
                        </Link>
                      </h5>

                      <p className="card-text text-muted small mb-4 flex-grow-1" style={{ lineHeight: '1.6' }}>
                        {post.short_description && post.short_description.length > 130
                          ? `${post.short_description.substring(0, 130)}...`
                          : post.short_description}
                      </p>

                      <div className="mt-auto pt-3 border-top">
                        <Link
                          href={`/blog/${post.slug}`}
                          className="text-dark fw-bold text-decoration-underline read-more-btn small"
                        >
                          Read More <i className="fas fa-arrow-right ms-1 text-primary" />
                        </Link>
                      </div>
                    </div>
                  </div>
                </div>
              ))
            )}
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
