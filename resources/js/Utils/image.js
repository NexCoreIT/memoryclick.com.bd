export function resolveImageUrl(path) {
  if (!path) return "/fav.png";
  if (path.startsWith("http://") || path.startsWith("https://") || path.startsWith("//")) {
    return path;
  }
  return path.startsWith("/") ? path : `/${path}`;
}
