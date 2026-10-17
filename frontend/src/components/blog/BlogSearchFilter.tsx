"use client";

import React, { useState } from "react";
import Link from "next/link";
import { useRouter, useSearchParams } from "next/navigation";
import { BlogCategoryItem } from "@/lib/api";

interface BlogSearchFilterProps {
  categories: BlogCategoryItem[];
  selectedCategory?: string;
  initialSearch?: string;
}

export default function BlogSearchFilter({
  categories,
  selectedCategory,
  initialSearch = "",
}: BlogSearchFilterProps) {
  const router = useRouter();
  const searchParams = useSearchParams();
  const [searchTerm, setSearchTerm] = useState(initialSearch);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    const params = new URLSearchParams(searchParams.toString());
    if (searchTerm.trim()) {
      params.set("search", searchTerm.trim());
    } else {
      params.delete("search");
    }
    params.set("page", "1");
    router.push(`/blog?${params.toString()}`);
  };

  const getCategoryHref = (slug: string) => {
    const params = new URLSearchParams(searchParams.toString());
    if (slug === "all") {
      params.delete("category");
    } else {
      params.set("category", slug);
    }
    params.set("page", "1");
    return `/blog?${params.toString()}`;
  };

  return (
    <div className="row align-items-center justify-content-between mb-4 gy-3">
      {/* Categories Tabs */}
      <div className="col-lg-8 text-center text-lg-start d-flex flex-wrap gap-2">
        <Link
          href={getCategoryHref("all")}
          className={`btn btn-default shadow-none border-0 bg-transparent filter-button px-3 py-2 ${
            !selectedCategory || selectedCategory === "all" ? "active" : "text-muted"
          }`}
        >
          All
        </Link>
        {categories.map((cat) => (
          <Link
            key={cat.id}
            href={getCategoryHref(cat.slug)}
            className={`btn btn-default shadow-none border-0 bg-transparent filter-button px-3 py-2 ${
              selectedCategory === cat.slug ? "active" : "text-muted"
            }`}
          >
            {cat.name} ({cat.posts_count})
          </Link>
        ))}
      </div>

      {/* Search Bar */}
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
  );
}
