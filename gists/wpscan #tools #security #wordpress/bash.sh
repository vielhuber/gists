wpscan --url https://www.domain.tld

# compact
wpscan --no-banner --url https://www.domain.tld
wpscan --url https://www.domain.tld | grep '[!]'

# with wpvulndb.com api
wpscan --api-token xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx --url https://www.domain.tld | grep '[!]'

# diable ssl certificate warnings
wpscan --disable-tls-checks --url https://www.domain.tld