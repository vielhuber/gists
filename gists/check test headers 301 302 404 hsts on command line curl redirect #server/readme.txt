# show response headers
curl -sD - -o /dev/null https://www.tld.com

# ignore ssl errors
curl --insecure -I https://www.tld.local

# follow redirects
curl -L --max-redirs 500 "https://www.tld.local?foo=bar"

# check hsts
curl -s -D- https://www.tld.com | grep -i Strict