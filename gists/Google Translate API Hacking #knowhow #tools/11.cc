GURL AddApiKeyToUrl(const GURL& url) {
  return net::AppendQueryParameter(url, kApiKeyName, google_apis::GetAPIKey());
}