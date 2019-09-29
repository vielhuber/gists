// mysql
SELECT UUID();

// postgres
SELECT uuid_in(md5(random()::text || now()::text)::cstring);