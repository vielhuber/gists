SELECT unnest(ARRAY['foo','bar','baz']) as col

SELECT unnest FROM unnest(ARRAY['foo','bar','baz']) WHERE unnest = 'bar'